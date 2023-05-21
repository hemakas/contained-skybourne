<?php
/**
 *	Name	: MessagesRepository Class
 *	Project	: Skywings
 *	Creator	: S. Kaushalye
 *	Date	: 23-08-2016
 *	Desc	: This class consits of utility functions for mail send
 *	Version	: 01.00
 */

namespace App\Repositories;

use File;
use Storage;
use Illuminate\Support\Facades\Mail;

use App\Repositories\ImagesRepository;

class MessagesRepository
{
    /*
    public $_companycustomerqueriesemail = ['email'=>"online@skywings.co.uk", 'name'=>"Skywings Travel"];
    public $_bookingsemail = ['email'=>"online@skywings.co.uk", 'name'=>"Skywings Travel"];
    public $_mailattachmentdir = "attachments/";
    
    public $_defReplyto = ['email'=>"online@skywings.co.uk", 'name'=>"No Replay Skywings Travel"];
    */

    public $_companycustomerqueriesemail = ['email'=>"samurdhi.try@gmail.com", 'name'=>"Skybourne Travel"];
    public $_bookingsemail = ['email'=>"samurdhi.try@gmail.com", 'name'=>"Skybourne Travel"];
    public $_defReplyto = ['email'=>"samurdhi.try@gmail.com", 'name'=>"No Replay Skybourne Travel"];
    public $_mailattachmentdir = "attachments/";

    /**
     * Constructor function 
     * Set email addresses according to env
     */
    public function __construct() 
    {
        $environment = \Config::get('app.env');
        if($environment == "live" || $environment == "production")
        {
            $this->_companycustomerqueriesemail = ['email'=>"info@skybournetravels.com", 'name'=>"Skybourne Travels"];
            $this->_bookingsemail = ['email'=>"info@skybournetravels.com", 'name'=>"Skybourne Travel"];
            $this->_defReplyto = ['email'=>"info@skybournetravels.com", 'name'=>"No Replay Skybourne Travel"];
        }
    }
    
    /**
     * Send email
     * @param string $template: 'emails.messages'
     * @param array $data: [data array to pass to template]
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
    public function sendmail($subject, $template, $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto = [], $cc = '', $bcc = '', $attachmentFile = array(),  $memoryvar = null)
    {
        try {
            if(empty($replyto)){
                $replyto = $this->_defReplyto;
            }

            $oImgRepo = new ImagesRepository;
            $attachment = [0=>['path'=>"", 'file'=>"", 'filename'=>"", 'mimetype'=>""]];
            $attachData = ['file'=>"", 'filename'=>"", 'mimetype'=>""];

            if(!empty($attachmentFile)){
                if(is_array($attachmentFile)){
                    $x = 0;
                    foreach($attachmentFile as $atch){
                        
                        $attachmentPath = $oImgRepo->property_image_path['msgattachements']['upload_dir'].$atch;
                        //if (Storage::disk('resources')->get($attachmentPath)){ 
                        if(Storage::disk('public')->exists($attachmentPath)){
                            $attachment[$x]['file'] = Storage::disk('public')->get($attachmentPath);
                            $attachment[$x]['filename'] = $atch;
                            $attachment[$x]['mimetype'] = Storage::disk('public')->mimeType($attachmentPath);
                        } else {
                            return [0 => false, 'Error'=>"File not found", 'message' => "Unable to find attachement: ".$atch];
                            break;
                        }
                        $x++;
                    }
                } elseif($attachmentFile != ''){
                    $attachmentPath = $oImgRepo->property_image_path['msgattachements']['upload_dir'].$attachmentFile;
                    //if (Storage::disk('resources')->get($attachmentPath)){ 
                    if(Storage::disk('public')->exists($attachmentPath)){
                        $attachment[0]['file'] = Storage::disk('public')->get($attachmentPath);
                        $attachment[0]['filename'] = $attachmentFile;
                        $attachment[0]['mimetype'] = Storage::disk('public')->mimeType($attachmentPath);
                    } else {
                        return [0 => false, 'Error'=>"File not found", 'message' => "Unable to find attachement: ".$attachmentFile];
                    }
                }
            }

            if($memoryvar !== null){
                $attachData = ['file'=>$memoryvar, 'filename'=>"", 'mimetype'=>""];
            }
 
            $from = \Config::get('mail.from');
            $senderemail = $from['address']; 
            $sendername = $from['name']; 
            $data['subject'] = (isset($data['subject'])?$data['subject']:$subject);
            $data['sendtoemail'] = (isset($data['sendtoemail'])?$data['sendtoemail']:$sendtoemail);
            $data['sendtoname'] = (isset($data['sendtoname'])?$data['sendtoname']:$sendtoname);
            $data['datetime'] = (isset($data['datetime'])?$data['datetime']:date('Y-m-d H:i:s'));
            $data['senderemail'] = (isset($data['senderemail'])?$data['senderemail']:$senderemail);
            $data['sendername'] = (isset($data['sendername'])?$data['sendername']:$sendername);
   
            Mail::send($template, $data, function ($message) use ($subject, $senderemail, $sendername, $sendtoemail, $replyto, $cc, $bcc, $attachment) {
                $message->from($senderemail, $sendername);
                $message->to($sendtoemail)->subject($subject);
                $message->replyTo($replyto['email'], $replyto['name']);
                
                if(is_array($cc) && !empty($cc)){
                    foreach($cc as $c){
                        if(is_array($c)){
                            $message->cc($c[0], (isset($c[1])?$c[1]:null));
                        } else {
                            $message->cc($c);
                        }
                    }
                } elseif($cc != ''){
                    $message->cc($cc);
                }
                if(is_array($bcc) && !empty($bcc)){
                    foreach($bcc as $b){
                        if(is_array($b)){
                            $message->bcc($b[0], (isset($b[1])?$b[1]:null));
                        } else {
                            $message->bcc($b);
                        }
                    }
                } elseif($bcc != ''){
                    $message->bcc($bcc);
                }
                if(!empty($attachment) && isset($attachment[0]['file']) && $attachment[0]['file'] != ''){
                    foreach($attachment as $atch){
                        //$message->attach($attachment['path'], ['as' => $attachment['filename'], 'mime' => $attachment['mimetype']]);
                        $message->attachData($atch['file'], $atch['filename'], ['mime' => $atch['mimetype']]);                        
                    }
                }
            });
            return [0 => true, 'message' => 'Mail sent!', 'data'=>$data];
        
        } catch (Exception $ex) {
            return [0 => false, 'Error'=>$ex->getMessage(), 'File'=>$ex->getFile(), 'Line'=>$ex->getLine()];
        }
    }
    
    
}
