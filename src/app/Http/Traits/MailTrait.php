<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UsersTrait;

use DB;
use App\User;
use App\Client;
use File;
use Storage;
use Response;
use Validator;

trait MailTrait {
  
    protected $_companycustomerqueriesemail = ['email'=>"skaushalye@gmail.com", 'name'=>"Skybourne Travel"];
    protected $_bookingsemail = ['email'=>"testing@webgeniusonline.co.uk", 'name'=>"Skybourne Travel"];
    protected $_mailattachmentdir = "attachments/";
    
    protected $_defReplyto = ['email'=>"noreply@skybournetravels.co.uk", 'name'=>"No Replay Skybourne Travel"];
    
    // POST > /mails : send message
    public function sendMessage($layout, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto, $aCC, $aBCC, $attachmentFile)
    {
        try {
            return $this->sendmail($layout, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $replyto, $aCC, $aBCC, $attachmentFile);
	
        } catch (\Exception $ex) {
            if(env('APP_DEBUG') == false){
                return ['ERROR', 500];
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
    public function sendmail($layout, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $dataArray = [], $replyto = [], $cc = '', $bcc = '', $attachmentFile = '',  $memoryvar = null)
    {
        try {
            
        if(empty($replyto)){
            $replyto = $this->_defReplyto;
        }
        
        $attachment = ['path'=>"", 'file'=>"", 'filename'=>"", 'mimetype'=>""];
        $attachData = ['file'=>"", 'filename'=>"", 'mimetype'=>""];
            
        if($attachmentFile != ''){
            $attachmentPath = $this->_mailattachmentdir.$attachmentFile;
            if (Storage::disk('public')->get($attachmentPath)){ 
                $attachment['file'] = Storage::disk('public')->get($attachmentPath);
                $attachment['filename'] = $attachmentFile;
                $attachment['mimetype'] = Storage::disk('public')->mimeType($attachmentPath);
            }
        }

        if($memoryvar !== null){
            $attachData = ['file'=>$memoryvar, 'filename'=>"", 'mimetype'=>""];
        }
        
        $sendtoname = ($sendtoname == ""?$this->_companycustomerqueriesemail['name']:$sendtoname);
        $sendtoemail = ($sendtoemail == ""?$this->_companycustomerqueriesemail['email']:$sendtoemail);
        
        $data = array('subject'=>$subject, 'sendtoname'=>$sendtoname, 'body'=>$body, 'user_name'=>$sendernameinbody, 'datetime'=>date('Y-m-d h:i:s'), 
            'senderemail'=>$senderemail, 'sendername' => $sendername, 'sendtoemail'=>$sendtoemail, 'data'=>$dataArray);
        //echo "<br/>".$subject." | ".$senderemail." | ".$sendername." | ".$sendtoemail."<br/>";
        /*var_dump($senderemail);
        var_dump($sendtoemail);
        var_dump($replyto);
          var_dump($cc);die();*/
          //var_dump($bcc);
        Mail::send($layout, $data, function ($message) use ($subject, $senderemail, $sendername, $sendtoemail, $replyto, $cc, $bcc, $attachment) {
            $message->from($senderemail, $sendername);
            $message->to($sendtoemail)->subject($subject);
            $message->replyTo($replyto['email'], $replyto['name']);
            if(is_array($cc) && !empty($cc)){
                foreach($cc as $c){
                    $message->cc($c[0], (isset($c[1])?$c[1]:null));
                }
            } elseif($cc != ''){
                $message->cc($cc);
            }
            if(is_array($bcc) && !empty($bcc)){
                foreach($bcc as $b){
                    $message->bcc($b[0], (isset($b[1])?$b[1]:null));
                }
            } elseif($bcc != ''){
                $message->bcc($bcc);
            }
            if($attachment['file'] != ''){
                //$message->attach($attachment['path'], ['as' => $attachment['filename'], 'mime' => $attachment['mimetype']]);
                $message->attachData($attachment['file'], $attachment['filename'], ['mime' => $attachment['mimetype']]);
            }
        });
        return [0=>true, 'message' => 'Mail sent!', 'data'=>$data];
        
        } catch (Exception $ex) {
            echo "SMTP Error: ".$ex->getMessage();
        }
    }
    
    


}
