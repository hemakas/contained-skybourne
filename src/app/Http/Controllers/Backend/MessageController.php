<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;

use File;
use Storage;
use Response;
use Validator;
use Cache;
use DB;

use App\Admin;
use App\Message;
use App\Messagesinbox;
use App\Messagesoutbox;
use App\Messagesdraftbox;
use App\Messagelabel;
use App\Messageattachement;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Repositories\ImagesRepository;
use App\Http\Controllers\Backend\AdminuserTrait;

class MessageController extends Controller
{
    
    /**
     * This is trait class to validate requesting user
     */
    use AdminuserTrait;
       
    protected $_companydefemail = ['email'=>"skaushalye@gmail.com", 'name'=>"Senu Shipping"];
    protected $_companyagentqueriesemail = ['email'=>"skaushalye@gmail.com", 'name'=>"Senu Shipping"];
    protected $_companycustomerqueriesemail = ['email'=>"skaushalye@gmail.com", 'name'=>"Senu Shipping"];
        
    protected $_defReplyto = ['email'=>"noreply@eatdigi.com", 'name'=>"Senu Shipping"];
    
    protected $_ccemail = "skaushalye@gmail.com";
    protected $_testemail = "skaushalye@gmail.com";
    protected $_testemailname = "S K Munasinghe";
    
    /*
    protected $_companydefemail = ['email'=>"", 'name'=>"Senu Shipping"];
    protected $_companyagentqueriesemail = ['email'=>"", 'name'=>"Senu Shipping"];
    protected $_companycustomerqueriesemail = ['email'=>"", 'name'=>"Senu Shipping"];

    protected $_defReplyto = ['email'=>"noreply@eatdigi.com", 'name'=>"No Replay Senu Shipping"];

    protected $_ccemail = "";
    protected $_testemail = "";
    protected $_testemailname = "Paras";
    */
    
    /**
     * Authentication
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    

    // POST /mails : Show user inbox (or given folder Ex:sent)
    public function index(Request $request, $folder = 'inbox')
    {
        try {
            $user_type = $this->getUserType();
            $user_id = $this->getUserId();
            $username = $this->getUserFullname();
            if ($user_type === false || $user_type == 'client' || $user_id === false) {
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
                $messages = Messagesoutbox::with('message', 'user', 'auser', 'messagelabel')->where('auser_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } elseif ($folder == "draft") {
                $messages = Messagesdraftbox::with('message', 'user', 'auser', 'messagelabel')->where('auser_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } elseif ($folder == "trash") {
                if ($request->has('box') && $request->box == 'sent') {
                    $messages = Messagesoutbox::with('message', 'user', 'auser', 'messagelabel')->onlyTrashed()->where('auser_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
                } else {
                    $messages = Messagesinbox::with('message', 'user', 'auser', 'messagelabel')->onlyTrashed()->where('auser_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
                }
            } else {
                $messages = Messagesinbox::with('message', 'user', 'auser', 'messagelabel')->where('auser_id', '=', $user_id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            }
                        
            $username = ($username == ''?"Your":$username);
            //dd($messages);
            //return Response::json(
            return view('backend.messages.messagebox', [
                    'topic' => "$username mails in $folder",
                    'messages' => $messages,
                    'folder' => $folder
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
            $user_type = $this->getUserType();
            $user_id = $this->getUserId();
            $username = $this->getUserFullname();
            if ($user_type === false || $user_type == 'client' || $user_id === false) {
                return redirect('/admin/messages/inbox')->withErrors('Access denied!');
            }
            
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::with('message', 'user', 'auser', 'fromuser', 'fromauser', 'messagelabel')->where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::with('message', 'user', 'auser', 'fromuser', 'fromauser', 'messagelabel')->where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::with('message', 'user', 'auser', 'fromuser', 'fromauser', 'messagelabel')->where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
                // update as read
                if (isset($messages->id)) {
                    $mbin = Messagesinbox::find($messages->id);
                    $mbin->read   = 1;
                    $mbin->markasread = 1;
                    $mbin->save();
                    if (isset($messages->message_id)) {
                        Messagesoutbox::where('message_id', '=', $messages->message_id)
                                    ->update(['read' => '1', 'markasread'=>'1']);
                    }
                }
            }
            
            if (!$messages) {
                return redirect('/admin/messages/inbox')->withErrors('Unable to find this message!');
            }
            //dd($messages);
            return view('backend.messages.show', ['msg' => $messages, 'messagebox' => $messagebox]);
            /*
            return Response::json([
                    'msg' => $messages
            ]);*/
        } catch (\Exception $ex) {
            return redirect('/admin')->withErrors('Something went wrong!');
        }
    }
    
    
    // GET
    public function composeMessage(Request $request)
    {
        $user_id = $auser_id = 0;
            $request->flash();
        if ($request->isMethod('PATCH') && $request->has('draft_id') && $request->draft_id > 0) {
            $mailchain_id = $subject = $body = '';
            $user_type = $this->getUserType();
            if ($user_type == 'ADMIN' || $user_type == 'CMSUSER') {
                $draftmail = Messagesdraftbox::with('message', 'user', 'auser', 'messagelabel')->where('auser_id', '=', $this->getUserId())
                    ->where('id', '=', $request->draft_id)->first();
            } else {
                $draftmail = Messagesdraftbox::with('message', 'user', 'auser', 'messagelabel')->where('user_id', '=', $this->getUserId())
                    ->where('id', '=', $request->draft_id)->first();
            }
            $sendtouser_id = $draftmail->toauser_id > 0?$draftmail->toauser_id:$draftmail->touser_id;
            $sendtoemail = $draftmail->to;
            $sendtoname = $draftmail->toname;
            $subject = $draftmail->message->subject;
            $body = $draftmail->message->body;

            if ($sendtoname == '' && isset($draftmail->user->id)) {
                $user = User::with('client')->find($draftmail->user->id);
                $sendtoname = (isset($user->client->firstname)?$user->client->firstname:'');
            } elseif ($sendtoname == '' && isset($draftmail->auser->username)) {
                $sendtoname = $draftmail->auser->username;
            }
            return view('backend.messages.compose', [ 'draft_id' => $request->draft_id, 'sendtouser_id' => $sendtouser_id,
                    'sendtoemail' => $sendtoemail, 'sendtoname'=> $sendtoname,
                    'mailchain_id' => $mailchain_id, 'subject' => $subject, 'body'=>$body]);
        } elseif ($request->isMethod('PATCH') && $request->has('mailchain_id') && $request->mailchain_id > 0) {
            $mailchain_id = $request->mailchain_id;
            $replytomail = Messagesinbox::with('message', 'user', 'auser', 'fromuser', 'fromauser')->where('mailchain_id', '=', $request->mailchain_id)->where('auser_id', '=', $this->getUserId())
                    ->orderBy('updated_at', 'desc')->first();
            //return Response::json(['mcid'=>$mailchain_id,'data' => $replytomail ], 422);
            $sendtoemail = $sendtoname = $subject = $body = '';
            $sendtouser_id = ($replytomail->fromuser_id > 0?$replytomail->fromuser_id:($replytomail->fromuaser_id >0?$replytomail->fromuaser_id:0));
            if (isset($replytomail->message->subject)) {
                $subject = 'RE: '.$replytomail->message->subject;
                $body = '<br/><hr/><br/>'.$replytomail->message->body;
            }
            if ($replytomail->fromname != '') {
                $sendtoname = $replytomail->fromname;
                $sendtoemail = $replytomail->to;
            } else if ($sendtoemail == '' && isset($replytomail->to)) {
                $sendtoemail = $replytomail->to;
                $touser = User::where('email', '=', $replytomail->to)->first();
                $sendtoname = (isset($touser->username)?$touser->username:'');
            }
            return view('backend.messages.compose', [
                'sendtouser_id' => $sendtouser_id,
                    'sendtoemail' => $sendtoemail, 'sendtoname'=> $sendtoname,
                    'mailchain_id' => $mailchain_id, 'subject' => $subject, 'body'=>$body]);
        }
        $sendtouser_id = 0;
        $sendtoemail = $sendtoname = '';
        if ($request->has('sendtouser_id')) {
            $sendtouser_id = $request->sendtouser_id;
            $user = User::with('client')->find($request->sendtouser_id);
            if ($user) {
                $sendtoemail = $user->email;
                $sendtoname = (isset($user->client()->firstname)?trim($user->client()->title.' '.$user->client()->firstname.' '.$user->client()->lastname):$user->username);
            }
        }
        
        $mailchain_id = $subject = $body = '';
        if ($request->has('mailchain_id') && $request->mailchain_id != '') {
            $mailchain_id = $request->mailchain_id;
            $replytomail = Messagesinbox::with('message')->where('mailchain_id', '=', $request->mailchain_id)->where('auser_id', '=', $auser_id)
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
            
        return view('backend.messages.compose', ['sendtouser_id' => $sendtouser_id,
            'sendtoemail' => $sendtoemail, 'sendtoname'=> $sendtoname, 'mailchain_id' => $mailchain_id, 'subject' => $subject, 'body'=>$body]);
    }
    
    
    // DELETE DRAFT
    public function deleteDraft(Request $request)
    {
        if ($request->has('draft_id') && $request->draft_id > 0) {
            if (Messagesdraftbox::destroy($request->draft_id)) {
                return true;
            }
        }
        return false;
    }
    
    // POST > /mails : send message
    public function sendMessage(Request $request)
    {
            $request->flash();
        try {
            if ($request->submit == 'deletedraft') {
                $return = $this->deleteDraft($request);
                if ($return === true) {
                    return redirect('/admin/messages/inbox')->with('success', 'Drafted message deleted!');
                } else {
                    return redirect('/admin/messages/inbox')->withError('Unable to find drafted message to deleted!');
                }
            }
            if ($request->submit == 'save') {
                $this->saveDraft($request);
                return redirect('/admin/messages/inbox')->with('success', 'Message saved in drafts!');
            }
            $user_type = $this->getUserType();
            $user_id = $this->getUserId();
            $username = $this->getUserFullname();
            if ($user_type === false || $user_type == 'client' || $user_id === false) {
                return view('backend.messages.compose', ['errors'=> ['message'=> "Access denied!"]]);
            }
            
            $auser_id = 0;
            $sender = Admin::findOrFail($user_id);
            if (!($sender)) {
                return redirect('/admin/messages/inbox')->withErrors('Sender can not find!');
            } else {
                $auser_id = $user_id;
                $user_id = 0;
            }
            
            // Validate input feilds
            $rules = [  'subject' => 'required_without_all:mailchain_id|min:3',
                        'body' => 'required|min:10',
                        'mailchain_id' => 'numeric',
                        'sendtoemail' => 'required_without:mailchain_id|email',
                        'sendtoname' => 'min:2'
                    ];

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
            
            // Get sender usertype details
            switch ($sender->usertype) {
                case 'ADMIN':
                    $senderemail = $this->_companydefaultemail['email'];
                    $sendername = $this->_companydefaultemail['name'];
                    $sendernameinbody = $this->_companydefaultemail['name'];
                    $senderuser_id = $auser_id;
                    $sendtoemail = $request->sendtoemail;
                    $sendtoname = $request->sendtoname;
                    //if($request->has('withreplyto') && $request->withreplyto == true){
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    //}
                    break;
                
                case 'CMSUSER':
                    $senderemail = $this->_companydefaultemail['email'];
                    $sendername = $this->_companydefaultemail['name'];
                    $sendernameinbody = $sender->username;
                    $senderuser_id = $auser_id;
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
                    $senderuser_id = $auser_id;
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
                    $senderemail = $this->_testemail;
                    $sendername = 'TestingDef Customer';
                    $sendernameinbody = 'Default Name';
                    $senderuser_id = $auser_id;
                    $sendtoemail = $this->_testemail;
                    $sendtoname = $this->_testemailname;
                        $replyto['email'] = $senderemail;
                        $replyto['name'] = $sendername;
                    break;
            }
                   
            $sendtouser_id = ($request->has('sendtouser_id')?$request->sendtouser_id:'');
                        
            $subject = $request->subject;
                        
            // Set ReplyTo
            if ($request->has('mailchain_id') && $request->mailchain_id != '') {
                $replytomail = Messagesinbox::with('message')->where('mailchain_id', '=', $request->mailchain_id)->where('auser_id', '=', $auser_id)
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
                        return view('backend.messages.compose', [
                                    'errors' => [
                                        'message' => 'Invalid email in cc',
                                        'data' => ['cc' => ['Invalid email in cc']]
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
                        return view('backend.messages.compose', [
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
            if ($request->has('attachment')) {
                if (is_array($request->attachment) && !empty($request->attachment)) {
                    $attachmentFile = $request->attachment;
                } elseif ($request->attachment != '') {
                    $attachmentFile[] = $request->attachment;
                }
            }
            $view = 'emails.messages';
            $return = $this->sendmail($view, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto, $aCC, $aBCC, $attachmentFile);
            
            if (!isset($return['Error'])) {
                $message_id = 0;
                DB::transaction(function () use ($request, &$message_id, $user_id, $auser_id, $mailchain_id, $subject, $body, $sendtoemail, $cc, $bcc, $aCC, $aBCC, $attachmentFile) {
                    
                    $outbox = new Messagesoutbox([
                                            'user_id'  => $user_id,
                                            'auser_id'  => $auser_id,
                                            'mailchain_id'  => $mailchain_id,
                                            'to' => $sendtoemail,
                                            'cc' => $cc,
                                            'bcc' => $bcc,
                                            'label_id' => 0
                                        ]);
                    $message = Message::create([
                                    'user_id' => $user_id,
                                    'auser_id'  => $auser_id,
                                    'mailchain_id' => $mailchain_id,
                                    'subject' => $subject,
                                    'body' => $body,
                                ]);
                    
                    $message->messagesoutbox()->save($outbox);
                    
                    $message_id = $message->id;
                    
                    //if sent user email, save in user inbox
                    $findto = User::where('email', '=', $sendtoemail)->first();
                    
                    if (isset($findto->id)) {
                        $inbox = Messagesinbox::create([
                                                'user_id'  => $findto->id,
                                                'auser_id'  => $auser_id,
                                                'message_id' => $message_id,
                                                'mailchain_id'  => $mailchain_id,
                                                'to' => $sendtoemail,
                                                'cc' => $cc,
                                                'bcc' => $bcc,
                                                'read' => 0,
                                                'label_id' => 0
                                            ]);
                        $inbox->save();
                    }
                    
                    if (!empty($attachmentFile)) {
                        if (is_array($attachmentFile)) {
                            foreach ($attachmentFile as $atch) {
                                $ma = Messageattachement::create([
                                            'message_id' => $message_id,
                                            'filename' => $atch
                                        ]);
                                $ma->save();
                            }
                        } else {
                            $ma = Messageattachement::create([
                                        'message_id' => $message_id,
                                        'filename' => $attachmentFile
                                    ]);
                            $ma->save();
                        }
                    }
                    
                    if (!empty($aCC)) {
                        foreach ($aCC as $icc) {
                            if (isset($icc[2]) && $icc[2] > 0) {
                                $inbox = Messagesinbox::create([
                                            'user_id'  => $icc[2],
                                            'auser_id'  => 0,
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
                                            'auser_id'  => 0,
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
                
                if ($message_id > 0) {
                    if ($request->has('draft_id') && $request->draft_id > 0) {
                        $return = $this->deleteDraft($request);
                        if ($return === true) {
                            return redirect('/admin/messages/inbox')->with('success', 'Drafted message deleted!');
                        } else {
                            return redirect('/admin/messages/inbox')->withError('Unable to find drafted message to deleted!');
                        }
                    }
                    //return view('backend.messages.messagebox')->withSuccess("Message sent");
                    return redirect('/admin/messages/inbox')->with('success', 'Message sent!');
                }
            } else {
                $return = [ 'errors'=> ['message' => (isset($return['message'])?$return['message']:'Mail sending fail!')], 'data'=>false];
            }
            
            return view('backend.messages.compose', $return);
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
    public function sendmail($template, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto = [], $cc = '', $bcc = '', $attachmentFile = array(), $memoryvar = null)
    {
        try {
            if (empty($replyto)) {
                $replyto = $this->_defReplyto;
            }

            $oImgRepo = new ImagesRepository;
            $attachment = [0=>['path'=>"", 'file'=>"", 'filename'=>"", 'mimetype'=>""]];
            $attachData = ['file'=>"", 'filename'=>"", 'mimetype'=>""];

            if (!empty($attachmentFile)) {
                if (is_array($attachmentFile)) {
                    $x = 0;
                    foreach ($attachmentFile as $atch) {
                        $attachmentPath = $oImgRepo->property_image_path['msgattachements']['upload_dir'].$atch;
                        //if (Storage::disk('resources')->get($attachmentPath)){
                        if (Storage::disk('resources')->exists($attachmentPath)) {
                            $attachment[$x]['file'] = Storage::disk('resources')->get($attachmentPath);
                            $attachment[$x]['filename'] = $atch;
                            $attachment[$x]['mimetype'] = Storage::disk('resources')->mimeType($attachmentPath);
                        } else {
                            return ['Error'=>"File not found", 'message' => "Unable to find attachement: ".$atch];
                            break;
                        }
                        $x++;
                    }
                } elseif ($attachmentFile != '') {
                    $attachmentPath = $oImgRepo->property_image_path['msgattachements']['upload_dir'].$attachmentFile;
                    //if (Storage::disk('resources')->get($attachmentPath)){
                    if (Storage::disk('resources')->exists($attachmentPath)) {
                        $attachment[0]['file'] = Storage::disk('resources')->get($attachmentPath);
                        $attachment[0]['filename'] = $attachmentFile;
                        $attachment[0]['mimetype'] = Storage::disk('resources')->mimeType($attachmentPath);
                    } else {
                        return ['Error'=>"File not found", 'message' => "Unable to find attachement: ".$attachmentFile];
                    }
                }
            }

            if ($memoryvar !== null) {
                $attachData = ['file'=>$memoryvar, 'filename'=>"", 'mimetype'=>""];
            }

            $data = array('subject'=>$subject, 'sendtoname'=>$sendtoname, 'body'=>$body, 'user_name'=>$sendernameinbody, 'datetime'=>date('Y-m-d h:i:s'),
                'senderemail'=>$senderemail, 'sendername' => $sendername, 'sendtoemail'=>$sendtoemail);
            Mail::send(['html' => $template], $data, function ($message) use ($subject, $senderemail, $sendername, $sendtoemail, $replyto, $cc, $bcc, $attachment) {
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
                if (!empty($attachment) && isset($attachment[0]['file']) && $attachment[0]['file'] != '') {
                    foreach ($attachment as $atch) {
                        //$message->attach($attachment['path'], ['as' => $attachment['filename'], 'mime' => $attachment['mimetype']]);
                        $message->attachData($atch['file'], $atch['filename'], ['mime' => $atch['mimetype']]);
                    }
                }
            });
            return ['message' => 'Mail sent!', 'data'=>$data];
        } catch (Exception $ex) {
            return ['Error'=>$ex->getMessage(), 'File'=>$ex->getFile(), 'Line'=>$ex->getLine()];
        }
    }
    
    
    // POST > /mails : send message
    public function saveDraft(Request $request)
    {
            $request->flash();
        try {
            // Validate input feilds
            $rules = [  'subject' => 'required_without_all:mailchain_id|min:3',
                        'body' => 'min:10',
                        'mailchain_id' => 'numeric',
                        'sendtoemail' => 'required_without:mailchain_id|email',
                        'sendtoname' => 'min:2'
                    ];

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
            
            $auser_id = 0;
            $user_id = $this->getUserId();
            $sender = Admin::findOrFail($user_id);
            if (!($sender)) {
                return view('backend.messages.compose', [
                                    'error' => [
                                        'message' => 'Sender can not find!',
                                    ]
                                ], 422);
            } else {
                $auser_id = $user_id;
                $user_id = 0;
            }
            
            if (($request->has('subject') && trim($request->subject) != '') || ($request->has('body') && trim($request->body) != '')) {
                $mailchain_id = ($request->has('mailchain_id') ? trim($request->mailchain_id) : '');
                $subject = ($request->has('subject') ? trim($request->subject) : '');
                $body = ($request->has('body') ? trim($request->body) : '');
                $sendtoemail = ($request->has('sendtoemail') ? trim($request->sendtoemail) : '');
                $sendtoname = ($request->has('sendtoname') ? trim($request->sendtoname) : '');
                $cc = ($request->has('cc') ? trim($request->cc) : '');
                $bcc = ($request->has('bcc') ? trim($request->bcc) : '');
                        
                $message_id = 0;
                if ($request->has('draft_id') && $request->draft_id > 0) {
                    $draftmsg = Messagesdraftbox::with('user', 'auser', 'touser', 'toauser')->find($request->draft_id);
                    $touser_id = $toauser_id = 0;
                    if ($request->has('sendtouser_id') && $request->sendtouser_id > 0) {
                        $finduser = User::find($request->sendtouser_id);
                        if ($finduser->email != $request->sendtoemail) {
                            $finduser = Admin::find($request->sendtouser_id);
                            if ($finduser->email != $request->sendtoemail) {
                                $touser_id = $toauser_id = 0;
                            } else {
                                $toauser_id = $request->sendtouser_id;
                            }
                        } else {
                            $touser_id = $request->sendtouser_id;
                        }
                    }
                    
                    $draftmsg->user_id = $user_id;
                    $draftmsg->auser_id = $auser_id;
                    $draftmsg->touser_id = $touser_id;
                    $draftmsg->toauser_id = $toauser_id;
                    $draftmsg->mailchain_id = $mailchain_id;
                    $draftmsg->to = ($request->sendtoemail?$request->sendtoemail:$draftmsg->to);
                    $draftmsg->toname = ($request->sendtoname?$request->sendtoname:$draftmsg->toname);
                    $draftmsg->cc = $cc;
                    $draftmsg->bcc = $bcc;
                    $draftmsg->save();
                    $draftmsg->message()->update([
                                                'subject' => $subject,
                                                'body' => $body,
                                                ]);
                } else {
                    DB::transaction(function () use ($request, &$message_id, $user_id, $auser_id, $mailchain_id, $subject, $body, $sendtoemail, $sendtoname, $cc, $bcc) {
                        $draftbox = new Messagesdraftbox([
                        //$outbox = Messagesdraftbox::create([
                                                'user_id'  => $user_id,
                                                'auser_id'  => $auser_id,
                                                'mailchain_id'  => $mailchain_id,
                                                'to' => $sendtoemail,
                                                'toname' => $sendtoname,
                                                'cc' => $cc,
                                                'bcc' => $bcc,
                                                'label_id' => 0
                                            ]);

                        $message = Message::create([
                        //$message = new Message([
                                        'user_id' => $user_id,
                                        'auser_id'  => $auser_id,
                                        'mailchain_id' => $mailchain_id,
                                        'subject' => $subject,
                                        'body' => $body,
                                    ]);

                        $message->messagesdraftbox()->save($draftbox);
                        //$outbox->message()->save($message);

                        $message_id = $message->id;
                    });
                }
                return redirect('/admin/messages/inbox')->with('success', 'Message saved in drafts!');
            }
            return view('backend.messages.compose', [
                                    'error' => [
                                        'message' => 'Empty fields',
                                    ]
                                ], 422);
        } catch (\Exception $ex) {
            return redirect('/admin/messages/inbox')->withErrors('Message not saved in drafts!');
        }
    }
           
    
    // Update message
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
                $messages = Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
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
                return Response::json([
                        'message' => 'Message Succesfully Deleted'
                ]);
            } else {
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
                $messages = Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
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
                $messages = Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
            } else {
                $messages = Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailbox_id)->first();
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
        
    
    // Show labeled message
    public function getLabeledMessages($messagebox, $label, Request $request)
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
            
            $islabel = Messagelabel::where('name', '=', $label)->first();
            if (!isset($islabel->id)) {
                return Response::json([
                    'error' => [
                        'message' => 'Unable to find this label.'
                    ]
                ], 404);
            }
            
            $limit = $request->has('limit')?$request->limit:$this->_limit;
            $order = $request->has('order')?$request->order:"updated_at|DESC";
            $order = explode("|", $order);
            if ($messagebox == "sent") {
                $messages = Messagesoutbox::with('message', 'user', 'messagelabel')->where('auser_id', '=', $user_id)->where('label_id', '=', $islabel->id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } elseif ($messagebox == "draft") {
                $messages = Messagesdraftbox::with('message', 'user', 'messagelabel')->where('auser_id', '=', $user_id)->where('label_id', '=', $islabel->id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
            } else {
                $messages = Messagesinbox::with('message', 'user', 'messagelabel')->where('auser_id', '=', $user_id)->where('label_id', '=', $islabel->id)
                            ->orderBy((isset($order[0])?$order[0]:'updated_at'), (isset($order[1])?$order[1]:'DESC'))->paginate($limit);
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
            
            /*
            $message = DB::row("(SELECT *, 'inbox' as box FROM `messagesinbox` WHERE label_id = 3 AND user_id = 31)
                    UNION
                    (SELECT *, 'outbox' as box FROM `messagesoutbox` WHERE label_id = 3 AND user_id = 31)
                    ORDER BY updated_at LIMIT 4");
            */
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    // Send property details to someone elase
    public function sendPropertyToFirend(Request $request)
    {
        try {
            // Validate input feilds
            $rules = [  'toemail' => 'required|email',
                        'property_id' => 'required|numeric',
                    ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json([
                    'error' => [
                        'message' => 'Fields validation fail',
                        'data' => $validator->errors()
                    ]
                ], 422);
            }
            $return = true;
            
            return Response::json($return);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    // Set mail as read
    public function setMarkAsRead($messagebox, $mailboxmessage_id, Request $request)
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
            if ($messagebox == 'sent') {
                $msg = Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->first();
                if (!isset($msg->id)) {
                    return Response::json([
                        'error' => [
                            'message' => 'Unable to find this your message.'
                        ]
                    ], 404);
                }

                Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->update(['markasread' => '1']);
            } else {
                $msg = Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->first();
                if (!isset($msg->id)) {
                    return Response::json([
                        'error' => [
                            'message' => 'Unable to find this your message.'
                        ]
                    ], 404);
                }

                Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->update(['markasread' => '1']);
            }
            return Response::json([
                    'message' => 'This message marked as read.',
            ]);
        } catch (\Exception $ex) {
            if (env('APP_DEBUG') == false) {
                return Response::json(parent::$_apierrormsg, 500);
            } else {
                return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
            }
        }
    }
    
    
    // Set mail as unread
    public function setMarkAsUnread($messagebox, $mailboxmessage_id, Request $request)
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
            if ($messagebox == 'sent') {
                $msg = Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->first();
                if (!isset($msg->id)) {
                    return Response::json([
                        'error' => [
                            'message' => 'Unable to find this your message.'
                        ]
                    ], 404);
                }

                Messagesoutbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->update(['markasread' => '0']);
            } else {
                $msg = Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->first();
                if (!isset($msg->id)) {
                    return Response::json([
                        'error' => [
                            'message' => 'Unable to find this your message.'
                        ]
                    ], 404);
                }

                Messagesinbox::where('auser_id', '=', $user_id)->where('id', '=', $mailboxmessage_id)->update(['markasread' => '0']);
            }
            return Response::json([
                    'message' => 'This message marked as unread.',
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
