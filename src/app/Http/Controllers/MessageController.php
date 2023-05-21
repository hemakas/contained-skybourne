<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use File;
use Storage;
use Response;
use Validator;
use Cache;
use DBLog;
use DB;

use App\Message;
use App\Messagesinbox;
use App\Messagesoutbox;
use App\Messagesdraftbox;
use App\Messagelabel;
use App\Messagestatus;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Controllers\UtilityController;
use App\Repositories\CustomerRepository;
use App\Http\Controllers\UsersTrait;

class MessageController extends Controller
{
    
    /**
     * This is trait class to validate requesting user
     */
    use UsersTrait;
       
    protected $_companydefemail = ['email'=>"samurdhi.try@gmail.com", 'name'=>"ATP EATDigi"];
    protected $_companyagentqueriesemail = ['email'=>"samurdhi.try@gmail.com", 'name'=>"ATP EATDigi"];
    protected $_companycustomerqueriesemail = ['email'=>"samurdhi.try@gmail.com", 'name'=>"ATP EATDigi"];
    protected $_mailattachmentdir = "attachments/";
    
    protected $_defReplyto = ['email'=>"noreply@eatdigi.com", 'name'=>"No Replay EATDigi"];
    
    protected $_ccemail = "samurdhi.try@gmail.com";
    protected $_testemail = "samurdhi.try@gmail.com";
    
    /**
     * Authentication
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    

    // POST /mails : Show user inbox (or given folder Ex:sent)
    public function index(Request $request, $folder = 'inbox')
    {
        try {
            $username = '';
            if ($this->validateAdminUser($request) === true || $this->validateCMSUser($request) === true) {
                if ($request->has('user_id') && $request->user_id > 0) {
                    $user_id = $request->user_id;
                    $username = $this->getUsername($user_id);
                } else {
                    $user_id = $this->getUserId($request);
                }
            } elseif ($this->validateJustAgentUser($request) === true || $this->validateJustCustomerUser($request) === true) {
                $user_id = $this->getUserId($request);
            } else {
                //Log:ALERT
                DBLog::alert('audit', 'Access denied to messages');

                return Response::json([
                        'error' => [
                            'message' => 'Access denied!'
                        ]
                    ], 403);
            }
            
            $limit = $request->has('limit')?$request->limit:$this->_limit;
            $order = $request->has('order')?$request->order:"updated_at|DESC";
            $order = explode("|", $order);
            if ($folder == "sent") {
                $messages = Messagesoutbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } elseif ($folder == "draft") {
                $messages = Messagesdraftbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } else {
                $messages = Messagesinbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            }
                        
            $username = ($username == ''?"Your":$username);
            return Response::json([
                    'message' => "$username mails in $folder",
                    'data' => $messages
            ]);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    // GET > /mails/{box}/{messageid} : display message content
    public function show($messagebox, $mailbox_id, Request $request)
    {
        try {
            if ($this->validateAdminUser($request) === true || $this->validateCMSUser($request) === true) {
                if ($request->has('user_id') && $request->user_id > 0) {
                    $user_id = $request->user_id;
                    //Log:ALERT
                    DBLog::alert('audit', "Admin/CMS user check others' messages. UserID:".$this->getUserId($request).". Other UserID:".$user_id);
                } else {
                    $user_id = $this->getUserId($request);
                }
            } elseif ($this->validateJustAgentUser($request) === true || $this->validateJustCustomerUser($request) === true) {
                $user_id = $this->getUserId($request);
            } else {
                //Log:ALERT
                DBLog::alert('audit', 'Access denied to messages');

                return Response::json([
                        'error' => [
                            'message' => 'Access denied!'
                        ]
                    ], 403);
            }
            
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::with('message', 'user', 'messagelabel')->where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            }
            
            if (!$messages) {
                return Response::json([
                    'error' => [
                        'message' => 'Unable to find this message.'
                    ]
                ], 404);
            }
            return Response::json([
                    'message' => 'Mail',
                    'data' => $messages
            ]);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return [$ex->getMessage(), $ex->getFile(), $ex->getLine()];
            }
        }
    }
    
    
    // POST > /mails : send message
    public function sendMessage(Request $request)
    {
        try {
            $user_id = $this->getUserId($request);
            if (!($user_id > 0)) {
                //Log:ALERT
                DBLog::alert('audit', 'Access denied to compose a message.');

                return Response::json([
                        'error' => [
                            'message' => 'Access denied to compose a message!'
                        ]
                    ], 403);
            }
            
            $sender = User::findOrFail($user_id);
            if (!($sender)) {
                //Log:ALERT
                DBLog::alert('audit', 'Sender can not find!');

                return Response::json([
                        'error' => [
                            'message' => 'Sender can not find!'
                        ]
                    ], 403);
            }
            
            // Validate input feilds
            $rules = [  'subject' => 'required_without_all:mailchain_id|min:3',
                        'body' => 'required|min:10',
                        'mailchain_id' => 'numeric'
                    ];

            if ($this->validateAdminUser($request) === true || $this->validateCMSUser($request) === true) {
                $rules['sendtoemail'] = 'required_without:mailchain_id|email';
                $rules['sendtoname'] = 'min:2';
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                //return redirect('post/create')->withErrors($validator)->withInput();
                return Response::json([
                    'error' => [
                        'message' => 'Fields validation fail',
                        'data' => $validator->errors()
                    ]
                ], 422);
            }
            
            $replyto = [];
            $subject = '';
            
            // Get sender usertype details
            switch ($sender->usertype) {
                case 'ADMIN':
                    $senderemail = $this->_companydefaultemail['email'];
                    $sendername = $this->_companydefaultemail['name'];
                    $sendernameinbody = $this->_companydefaultemail['name'];
                    $senderuser_id = $user_id;
                    $sendtoemail = $request->sendtoemail;
                    $sendtoname = $request->sendtoname;
                    if ($request->has('withreplyto') && $request->withreplyto == true) {
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    }
                    break;
                
                case 'CMSUSER':
                    $senderemail = $this->_companydefaultemail['email'];
                    $sendername = $this->_companydefaultemail['name'];
                    $sendernameinbody = $sender->username;
                    $senderuser_id = $user_id;
                    $sendtoemail = $request->sendtoemail;
                    $sendtoname = $request->sendtoname;
                    if ($request->has('withreplyto') && $request->withreplyto == true) {
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    }
                    break;
                
                case 'AGENT':
                    $senderemail = $sender->email;
                    $sendername = $sender->username;
                    $sendernameinbody = $sender->username;
                    $senderuser_id = $user_id;
                    $sendtoemail = $this->_companyagentqueriesemail['email'];
                    $sendtoname = $this->_companyagentqueriesemail['name'];
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    break;
                
                case 'CUSTOMER':
                    $senderemail = ($sender->email=='customer@atp.test'?'samurdhi.munasinghe@eatdigi.com':$sender->email);
                    $sendername = $sender->username;
                    $sendernameinbody = $sender->username;
                    $senderuser_id = $user_id;
                    $sendtoemail = $this->_companycustomerqueriesemail['email'];
                    $sendtoname = $this->_companycustomerqueriesemail['name'];
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    break;
                
                default:
                    $senderemail = "samurdhi.try@gmail.com";
                    $sendername = 'TestingDef Customer';
                    $sendernameinbody = 'Default Name';
                    $sendtoemail = "samurdhi.try@gmail.com";
                    $sendtoname = "S K Munasinghe";
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    break;
            }
                   
            $sendtouser_id = 0;
            $u = User::where('email', '=', $sendtoemail)->first();
            if (isset($u->id)) {
                $sendtouser_id = $u->id;
            }
            
            $subject = ($subject != ''?$subject:$request->subject);
            
            
            // Set ReplyTo
            if ($request->has('mailchain_id') && $request->mailchain_id != '') {
                $replytomail = Messagesinbox::with('message')->where('mailchain_id', '=', $request->mailchain_id)->where('user_id', '=', $user_id)
                        ->orderBy('updated_at', 'desc')->first();
                if (isset($replytomail->subject)) {
                    $subject = 'RE: '.$replytomail->subject;
                }
                if (isset($replytomail->to)) {
                    $sendtoemail = $replytomail->to;
                    $touser = User::where('email', '=', $replytomail->to)->first();
                    $sendtoname = (isset($touser->username)?$touser->username:'');
                }
            }
            
            $cc = '';
            $aCC = array();
            if ($request->has('cc') && $request->cc != '') {
                $cc = $request->cc;
                $a = explode(',', trim(trim($request->cc, ',')));
                foreach ($a as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                        $user = User::where('email', '=', $email)->first();
                        if (isset($user->id)) {
                            $aCC[] = [$email, $user->username, $user->id];
                        } else {
                            $aCC[] = [$email];
                        }
                    } else {
                        return Response::json([
                                    'error' => [
                                        'message' => 'Invalid email in cc',
                                        'data' => ['bcc' => ['Invalid email in cc']]
                                    ]
                                ], 422);
                    }
                    unset($email);
                    unset($user);
                }
            }
            
            $bcc = "";
            $aBCC = array();
            if ($request->has('bcc') && $request->bcc != '') {
                $bcc = $request->bcc;
                $b = explode(',', trim(trim($request->bcc, ',')));
                foreach ($b as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                        $user = User::where('email', '=', $email)->first();
                        if (isset($user->id)) {
                            $aBCC[] = [$email,$user->username, $user->id];
                        } else {
                            $aBCC[] = [$email];
                        }
                    } else {
                        return Response::json([
                                    'error' => [
                                        'message' => 'Invalid email in bcc',
                                        'data' => ['bcc' => ['Invalid email in bcc']]
                                    ]
                                ], 422);
                    }
                    unset($email);
                    unset($user);
                }
            }
            
            $mailchain_id = ($request->has('mailchain_id') && trim($request->mailchain_id) != ''?$request->mailchain_id:time().rand(0, 999));
            $body = $request->body;
            $attachmentFile = '';
            if ($request->has('attachment') && $request->attachment != '') {
                $attachmentFile = $request->attachment;
            }
            $return = $this->sendmail($subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto, $aCC, $aBCC, $attachmentFile);
            
            if (isset($return['message']) && $return['message']== "Mail sent!") {
                $message_id = 0;
                DB::transaction(function () use ($request, &$message_id, $user_id, $mailchain_id, $subject, $body, $sendtoemail, $cc, $bcc, $aCC, $aBCC) {
                    
                    $outbox = new Messagesoutbox([
                                            'user_id'  => $user_id,
                                            'mailchain_id'  => $mailchain_id,
                                            'to' => $sendtoemail,
                                            'cc' => $cc,
                                            'bcc' => $bcc,
                                            'label_id' => 0
                                        ]);
                    $message = Message::create([
                                    'user_id' => $user_id,
                                    'mailchain_id' => $mailchain_id,
                                    'subject' => $subject,
                                    'body' => $body,
                                ]);
                    $message->messagesoutbox()->save($outbox);
                    
                    $message_id = $message->id;
                    
                    if (!empty($aCC)) {
                        foreach ($aCC as $icc) {
                            if (isset($icc[2]) && $icc[2] > 0) {
                                $inbox = Messagesinbox::create([
                                            'user_id'  => $icc[2],
                                            'message_id' => $message_id,
                                            'mailchain_id'  => $mailchain_id,
                                            'to' => $sendtoemail,
                                            'cc' => $cc,
                                            'bcc' => $bcc,
                                            'label_id' => 0
                                        ]);
                                $inbox->save();
                            }
                        }
                    }
                    
                    if (!empty($aBCC)) {
                        foreach ($aBCC as $ibcc) {
                            if (isset($ibcc[2]) && $ibcc[2] > 0) {
                                $inbox = Messagesinbox::create([
                                            'user_id'  => $ibcc[2],
                                            'message_id' => $message_id,
                                            'mailchain_id'  => $mailchain_id,
                                            'to' => $sendtoemail,
                                            'cc' => $cc,
                                            'bcc' => $bcc,
                                            'label_id' => 0
                                        ]);
                                $inbox->save();
                            }
                        }
                    }
                });
                
                if ($message_id > 0 && $request->has('draft_id') && $request->draft_id > 0) {
                    if (Messagesdraftbox::destroy($request->draft_id)) {
                        $done = true;
                    }
                }
            }
            
            //Log:INFO
            DBLog::write('audit', "Message sent:".$message_id.". User Id: ".$user_id);

            return Response::json($return);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    
    /**
     * Send email
     * @param string $subject
     * @param string $body
     * @param string $sendtoname
     * @param string $sendernameinbody
     * @param string $senderemail
     * @param string $sendername
     * @param string $sendtoemail
     * @param array $attachment
     * @param array $attachData
     * @param byte $memoryvar
     * @return array
     */
    public function sendmail($subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto = [], $cc = '', $bcc = '', $attachmentFile = '', $memoryvar = null)
    {
        if (empty($replyto)) {
            $replyto = $this->_defReplyto;
        }
        
        $attachment = ['path'=>"", 'file'=>"", 'filename'=>"", 'mimetype'=>""];
        $attachData = ['file'=>"", 'filename'=>"", 'mimetype'=>""];
            
        if ($attachmentFile != '') {
            $attachmentPath = $this->_mailattachmentdir.$attachmentFile;
            if (Storage::disk('resources')->get($attachmentPath)) {
                $attachment['file'] = Storage::disk('resources')->get($attachmentPath);
                $attachment['filename'] = $attachmentFile;
                $attachment['mimetype'] = Storage::disk('resources')->mimeType($attachmentPath);
            }
        }

        if ($memoryvar !== null) {
            $attachData = ['file'=>$memoryvar, 'filename'=>"", 'mimetype'=>""];
        }
        
        $data = array('subject'=>$subject, 'sendtoname'=>$sendtoname, 'body'=>$body, 'user_name'=>$sendernameinbody, 'datetime'=>date('Y-m-d h:i:s'),
            'senderemail'=>$senderemail, 'sendername' => $sendername, 'sendtoemail'=>$sendtoemail);
        Mail::send('emails.messages', $data, function ($message) use ($subject, $senderemail, $sendername, $sendtoemail, $replyto, $cc, $bcc, $attachment) {
            $message->from($senderemail, $sendername);
            $message->to($sendtoemail)->subject($subject);
            $message->replyTo($replyto['email'], $replyto['name']);
            if (is_array($cc) && !empty($cc)) {
                foreach ($cc as $c) {
                    $message->cc($c[0], (isset($c[1])?$c[1]:null));
                }
            } elseif ($cc != '') {
                $message->cc($cc);
            }
            if (is_array($bcc) && !empty($bcc)) {
                foreach ($bcc as $b) {
                    $message->bcc($b[0], (isset($b[1])?$b[1]:null));
                }
            } elseif ($bcc != '') {
                $message->bcc($bcc);
            }
            if ($attachment['file'] != '') {
                //$message->attach($attachment['path'], ['as' => $attachment['filename'], 'mime' => $attachment['mimetype']]);
                $message->attachData($attachment['file'], $attachment['filename'], ['mime' => $attachment['mimetype']]);
            }
        });
        return ['message' => 'Mail sent!', 'data'=>$data];
    }
    
    
    
    // POST > /mails : send message
    public function saveDraft(Request $request)
    {
        try {
            $user_id = $this->getUserId($request);
            if (!($user_id > 0)) {
                return Response::json([
                        'error' => [
                            'message' => 'Access denied to save a message!'
                        ]
                    ], 403);
            }
            
            if (($request->has('subject') && trim($request->subject) != '') || ($request->has('body') && trim($request->body) != '')) {
                $mailchain_id = ($request->has('mailchain_id') ? trim($request->mailchain_id) : '');
                $subject = ($request->has('subject') ? trim($request->subject) : '');
                $body = ($request->has('body') ? trim($request->body) : '');
                $sendtoemail = ($request->has('sendtoemail') ? trim($request->sendtoemail) : '');
                $cc = ($request->has('cc') ? trim($request->cc) : '');
                $bcc = ($request->has('bcc') ? trim($request->bcc) : '');
                        
                $message_id = 0;
                DB::transaction(function () use ($request, &$message_id, $user_id, $mailchain_id, $subject, $body, $sendtoemail, $cc, $bcc) {
                    $draftbox = new Messagesdraftbox([
                    //$outbox = Messagesdraftbox::create([
                                            'user_id'  => $user_id,
                                            'mailchain_id'  => $mailchain_id,
                                            'to' => $sendtoemail,
                                            'cc' => $cc,
                                            'bcc' => $bcc,
                                            'label_id' => 0
                                        ]);
                    
                    $message = Message::create([
                    //$message = new Message([
                                    'user_id' => $user_id,
                                    'mailchain_id' => $mailchain_id,
                                    'subject' => $subject,
                                    'body' => $body,
                                ]);

                    $message->messagesdraftbox()->save($draftbox);
                    //$outbox->message()->save($message);
                    
                    $message_id = $message->id;
                });
                                
                return Response::json([
                        'message' => 'Message saved in drafts',
                        'data' => ['message_id'=>$message_id]
                ], 200);
            }
            
            return Response::json([
                    'error' => [
                        'message' => 'Empty fields'
                    ]
                ], 502);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
           
    
    
    public function update($message_id, Request $request)
    {
        try {
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    public function destroy($messagebox, $mailbox_id, Request $request)
    {
        try {
            $user_id = $this->getUserId($request);
            if (!($user_id > 0)) {
                return Response::json([
                        'error' => [
                            'message' => 'Access denied to delete a message!'
                        ]
                    ], 403);
            }
            
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            }
            
            if (!$messages) {
                return Response::json([
                    'error' => [
                        'message' => 'Unable to find this message.'
                    ]
                ], 404);
            }
            
            $done = false;
            if ($messagebox == "sent") {
                if (Messagesoutbox::destroy($messages->id)) {
                    $done = true;
                }
            } elseif ($messagebox == "draft") {
                if (Messagesdraftbox::destroy($messages->id)) {
                    $done = true;
                }
            } else {
                if (Messagesinbox::destroy($messages->id)) {
                    $done = true;
                }
            }
            
            if ($done === true) {
                //Log:INFO
                DBLog::write('audit', "Message deleted. Message id:".$messages->id.". User id:".$user_id);

                return Response::json([
                        'message' => 'Message Succesfully Deleted'
                ]);
            } else {
                //Log:ALERT
                DBLog::alert('audit', "Can not find given message to delete. Message Id:".$messages->id);

                return Response::json([
                    'error' => [
                        'message' => 'Can not find given message'
                    ]
                ], 400);
            }
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    // GET message labels
    public function getLabels()
    {
        try {
            $labels = Messagelabel::all();
            return Response::json([
                    'data' => $labels
            ]);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    
    // Set Label to message
    public function setLabel($messagebox, $mailbox_id, Request $request)
    {
        try {
            $user_id = $this->getUserId($request);
            if (!($user_id > 0)) {
                return Response::json([
                        'error' => [
                            'message' => 'Access denied to save a message!'
                        ]
                    ], 403);
            }
            
            
            // Validate input feilds
            $validator = Validator::make($request->all(), [
                            'label_id' => 'required|numeric|min:1',
                        ]);

            if ($validator->fails()) {
                return Response::json([
                    'error' => [
                        'message' => 'Fields validation fail',
                        'data' => $validator->errors()
                    ]
                ], 422);
            }

            
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            }
            
            if (!$messages) {
                return Response::json([
                    'error' => [
                        'message' => 'Unable to find this message.'
                    ]
                ], 404);
            }
            
            $messages->label_id = ($request->has('label_id')?$request->label_id:0);

            $messages->save();

            return Response::json([
                    'message' => 'Label assigned to the message',
                    'data' => ['mailbox_id'=>$mailbox_id, 'label_id'=>$messages->label_id]
            ], 200);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    // Remove Label from a message
    public function removeLabel($messagebox, $mailbox_id, Request $request)
    {
        try {
            $user_id = $this->getUserId($request);
            if (!($user_id > 0)) {
                return Response::json([
                        'error' => [
                            'message' => 'Access denied to save a message!'
                        ]
                    ], 403);
            }
            
            
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('user_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            }
            
            if (!$messages) {
                return Response::json([
                    'error' => [
                        'message' => 'Unable to find this message.'
                    ]
                ], 404);
            }
            
            $messages->label_id = 0;

            $messages->save();


            return Response::json([
                    'message' => 'Label removed from the message',
                    'data' => ['message_id'=>$mailbox_id]
            ]);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
}
