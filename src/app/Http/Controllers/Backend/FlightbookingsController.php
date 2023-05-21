<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Validator;
use Hash;

use App\Payment;
use App\User;
use App\Flightbookingrequest;

class FlightbookingsController extends Controller
{
    /**
     * The Payment repository instance.
     *
     * @var PaymentRepository
     */
    protected $flightbookingrequest;
    
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
        $bookings = Flightbookingrequest::with('passengers', 'cardpayments')->orderBy('created_at', 'desc')->paginate($limit);
        //dd($bookings);
        return view('backend.flightbooking.list', [
            'bookings' => $bookings
        ]);
    }
}
