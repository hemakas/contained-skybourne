<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Validator;
use Hash;
use DateTime;
use DateInterval;

use App\Paymentrequest;
use App\User;
use App\Repositories\MessagesRepository;

class PaymentsController extends Controller
{
    /**
     * The Payment repository instance.
     *
     * @var PaymentRepository
     */
    protected $payment;
    
    /**
     * Create a new controller instance.
     *
     * @param  PaymentRepository  $Payment
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display a list of all payments.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $paymentreqs = Paymentrequest::orderBy('created_at', 'asc')->paginate($limit);
        //dd($paymentreqs);
        return view('backend.payment.list', [
            'paymentrequests' => $paymentreqs
        ]);
    }
    
    public function cronExpiredRequests()
    {
        //DB::enableQueryLog();
        Paymentrequest::where(function ($query) {
            $query->where("status", "=", "REQUEST")
                  ->orWhere("status", "=", "CLICKED");
        })->where(function ($query) {
            $dateTimeObj= new DateTime();
            $now = $dateTimeObj->format('Y-m-d H:i:s');
            $query->where('expiredon', '<', $now);
        })->update(['status' => "EXPIRED"]);
        //dd(DB::getQueryLog());
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        if ($request->has('firstname') || $request->has('lastname')) {
            $rules = [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'adrsline1' => 'required|max:255',
                        'town' => 'required|max:255',
                        'email' => 'required|email',
                        'amount' => "required|regex:/^\d*(\.\d{2})?$/"
                    ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return view('backend.payment.store', [
                    'errors'=>$validator->errors(),
                ]);
            }

            $id = 0;
            $token = "";
            DB::transaction(function () use ($request, &$id, &$token) {
                $expiredin = ($request->has('expiredin')?$request->expiredin:1);
                $dateTimeObj= new DateTime();
                $expiredon = $dateTimeObj->add(new DateInterval("PT".$expiredin."H"))->format('Y-m-d H:i:s');

                $payreq = new Paymentrequest;
                
                $transactionid = 'DP'.date('dmy').str_pad(rand(1, 9999), 4, 0, STR_PAD_LEFT);
                $amount = ($request->has('amount')?$request->amount:'');
                $token = md5($transactionid.$payreq->expiredon);
                
                $payreq->token = $token;
                $payreq->expiredon = $expiredon;
                $payreq->transactionid = $transactionid;
                $payreq->status = 'REQUEST';
                $payreq->amount = $amount;
                $payreq->reference = ($request->has('reference')?$request->reference:'');
                $payreq->title = ($request->has('title')?$request->title:'');
                $payreq->firstname = ($request->has('firstname')?$request->firstname:'');
                $payreq->lastname = ($request->has('lastname')?$request->lastname:'');
                $payreq->phone = ($request->has('phone')?$request->phone:'');
                $payreq->email = ($request->has('email')?$request->email:'');
                $payreq->adrsline1 = ($request->has('adrsline1')?$request->adrsline1:'');
                $payreq->adrsline2 = ($request->has('adrsline2')?$request->adrsline2:'');
                $payreq->town = ($request->has('town')?$request->town:'');
                $payreq->postcode = ($request->has('postcode')?$request->postcode:'');
                $payreq->county = ($request->has('county')?$request->county:'');
                $payreq->country = ($request->has('country')?$request->country:'');
                $payreq->description = ($request->has('description')?$request->description:'');
                $payreq->save();
                $id = $payreq->id;
            });
            
            // Send direct payment email
            $mailresponse = $this->sendDirectPaymentMail($id);
            
            return redirect('/admin/payments/get/'.$id)->with('success', 'Payment request sent!');
        } else {
            return view('backend.payment.store', []);
        }
    }
    
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $payreq = Paymentrequest::with('cardpayments')->find($id);
        if (!$payreq) {
            return view('backend.payment.list', [
                'error' => [
                    'message' => 'Unable to fine payment request!'
                ]
            ], 404);
        }
        //dd($payreq->toArray());
        return view('backend.payment.show', [
            'payreq' => $payreq,
            'paymentDetails' => $payreq->cardpayments
        ]);
    }
    
    private function sendDirectPaymentMail($id)
    {
        $mailresponse = [0=>false];
        $payreq = Paymentrequest::find($id);
        if (!$payreq) {
            $mailresponse = [0=>false, 'message'=>"Unable to find the payment request details to generate an email!"];
        } else {
            $aPayReq = $payreq->toArray();
            $aPayReq['expiredon'] = \Carbon\Carbon::parse($aPayReq['expiredon'])->format('d/m/Y H:i');
            
            // Send mail
            $oMsgRepo = new MessagesRepository();
            $layout = "emails.directpayment";
            $subject = "Payment Request from Skywings Travel";
            $sendtoemail = $payreq->email;
            $sendtoname = trim($payreq->firstname.($payreq->lastname != ""?" ".$payreq->lastname:''));
            $sendernameinbody = "Skywings Travel";
            $senderemail = $oMsgRepo->_companycustomerqueriesemail['email'];
            $sendername = $oMsgRepo->_companycustomerqueriesemail['name'];
            $replyto = $oMsgRepo->_companycustomerqueriesemail;
            $cc = "";
            $bcc = "";
            $attachmentFile = "";
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'requestDetails' => $aPayReq,
                'datetime' => date('y-m-d h:i:s'),
                'errorData' => []];
            $mailresponse = $oMsgRepo->sendmail(
                $subject,
                $layout,
                $data,
                $sendtoemail,
                $sendtoname,
                $senderemail,
                $sendername,
                $replyto,
                $cc,
                $bcc
            );
            $mailresponse['sendtoemail'] = $sendtoemail;
            return $mailresponse;
        }
        return $mailresponse;
    }
}
