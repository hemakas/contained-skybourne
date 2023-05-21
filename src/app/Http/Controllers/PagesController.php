<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Externals\Sabreapi\Sabrecall;
use App\Repositories\ImagesRepository;
use App\Repositories\FilesRepository;
use App\Repositories\MessagesRepository;

use DB;
use Response;
use Validator;
use Hash;
use DateTime;
use Session;
use Storage;

use App\Http\Traits\UserTrait;
use App\Http\Traits\PagesTrait;
use App\Http\Traits\MailTrait;
use App\Http\Helpers\StringHelper;
//use App\Http\Requests\PassengerRequest;
use App\Itinerary;
use App\Testimonial;
use App\Hotel;
use App\Client;
use App\User;
use App\Delivery;
use App\Deliverystatus;
use App\Payment;
use App\Country;
use App\Flightbookingrequest;
use App\Passengers;
use App\Cardpayments;
use App\Carousel;
use App\Paymentrequest;

/**
 * PagesController
 * @package    Controller
 * @author     skaushalye
 */
class PagesController extends BaseController
{
    use UserTrait;
    use PagesTrait;
    use MailTrait;

    /**
     * paging limit
     * @var int
     */
    public $_limit = 10;

    /**
     * Current transaction id
     * @var int
     */
    private $transactionid = "";

    /**
     * Company address
     * @var array
     */
    private $agencyAddress = [
        "StreetNmbr" => "119 Tooting High Street",
        "AddressLine" => "Skybourne Limited",
        "CityName" => "London",
        "CountryCode" => "GB",
        "PostalCode" => "SW17 0SY",
        "StateCode" => ""
    ];

    /**
     * Get transaction id
     * @return string
     */
    private function getTransactionId()
    {
        return $this->transactionid;
    }

    /**
     * Set transaction Id
     * @param string $trnId
     */
    private function setTransactionId($trnId)
    {
        $this->transactionid = $trnId;
    }

    /**
     * @return render view
     */
    public function viewoffer()
    {
        return view('pages.viewoffer', [
            'name' => "view offer"
        ]);
    }

    /**
     * @return render view
     */
    public function viewtour()
    {
        return view('pages.viewtour', [
            'name' => "view tour"
        ]);
    }

    public function testaction()
    {
    return view('pages.testaction', [
            'name' => "Test Page",
        ]);
    }

    /**
     * Index/Home page
     * @return render view
     */
    public function index(Request $request)
    {
        //var_dump($request->ip());
        $request->flash();
        $fileRepo = new FilesRepository;
        $loggedUserName = "";
        if (Auth::guard('user')->user()) {
            $loggedUserName = Auth::guard('user')->user();
        }
        $featuredItineraries = Itinerary::with('itineraryimage')->where('active', 1)->where('featured', 1)->get();
        $testimonials = Testimonial::where('active', 1)->get();

        $carousel = Carousel::where('place_id', '1')->where('active', 1)->get();
        //dd($carousel);
        return view('pages.index', [
            'name' => "Welcome",
            'loggedUserName' => $loggedUserName,
            'testimonials' => $testimonials,
            'featuredItineraries' => $featuredItineraries,
            'image_dir' => $fileRepo->file_paths['itineraries']['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            'carousel' => $carousel,
        ]);
    }

    /**
     * About us page
     * @return render view
     */
    public function aboutus()
    {
        return view('pages.aboutus', [
            'name' => "About Us"
        ]);
    }


    /**
     * Holidy Types page
     * @return render view
     */
    public function holidaytypes()
    {
        return view('pages.holidaytypes', [
            'name' => "Holiday Types"
        ]);
    }

    /**
     * privacypolicy page
     * @return render view
     */
    public function privacypolicy()
    {
        return view('pages.privacypolicy', [
            'name' => "Privacy Policy"
        ]);
    }

    /**
     * Terms & conditions page
     * @return render view
     */
    public function termsconditions()
    {
        return view('pages.termsconditions', [
            'name' => "Terms & Conditions"
        ]);
    }

    /**
     * Customer support page
     * @return render view
     */
    public function customersupport(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [  'customername' => 'required|max:255',
                        'email' => 'required|email',
                        'message' => 'required|min:10',
                ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('pages.customersupport', [
                    'name' => "Customer Support",
                    'errors'=>$validator->errors(),
                ]);
            }

            $repoMessage = new MessagesRepository();
            $name = ($request->customername?$request->customername:"");
            $telephone = ($request->phone?$request->phone:"");
            $email = ($request->email?$request->email:"");
            $address = ($request->address?$request->address:"");
            $message = ($request->message?$request->message:"");

            $layout = 'emails.contactform';
            $subject = "Skybourne.co.uk Customer Support - Contact form";
            $body = $message;
            $senderemail = "webbookings@skybournetravels.co.uk"; //$email;
            $sendername = "Skybourne"; //$name;
            $sendernameinbody = $name;
            $replyto = $aCC = $aBCC = [];
            $attachmentFile = "";
            $sendtoemail = $repoMessage->_companycustomerqueriesemail["email"];
            $sendtoname = $repoMessage->_companycustomerqueriesemail["name"];
            $data['data'] = ['name'=>$name, 'telephone'=>$telephone, 'email'=>$email, 'address'=>$address, 'message'=>$message];

            //$response = $this->sendMessage($layout, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $data, $replyto, $aCC, $aBCC, $attachmentFile);
            $response = $repoMessage->sendmail($subject, $layout,   $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto, $aCC, $aBCC, $attachmentFile);
                                    //sendmail($subject, $template, $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto = [], $cc = '', $bcc = '', $attachmentFile = array(),  $memoryvar = null)
                                    //sendmail($layout, $subject, $body, $sendtoname, $sendernameinbody, $senderemail, $sendername, $sendtoemail, $dataArray = [], $replyto = [], $cc = '', $bcc = '', $attachmentFile = '',  $memoryvar = null)
                                    //sendmail($subject, $template, $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto = [], $cc = '', $bcc = '', $attachmentFile = array(),  $memoryvar = null)

            if (isset($response[0]) && ($response[0] == true)) {
                return view('pages.customersupport', [
                    'name' => "Customer Support",
                    'success' => "Your message has been sent to Skybourne Travels."
                ]);
            } else {
                return view('pages.customersupport', [
                    'name' => "Customer Support",
                    'error' => "Something went wrong! Your message not sent to Skybourne Travels."
                ]);
            }
        }
        return view('pages.customersupport', [
                    'name' => "Customer Support"
                ]);
    }

    /**
     * Contact Page
     * @return render view
     */
    public function contact(Request $request)
    {
        return view('pages.contact', [
                    'name' => "Contact Us"
                ]);
    }

    /**
     * Login page
     * @return render view
     */
    public function login()
    {
        return view('pages.login', [
            'name' => "Login"
        ]);
    }

    /**
     * Successful message page
     * @return render view
     */
    public function success(Request $request)
    {
        return view('pages.success', ['trackingno'=>($request->has('trackingno')?$request->trackingno:'ERROR')]);
    }

    /**
     * Error page
     * @return render view
     */
    public function error(Request $request)
    {
        return view('pages.error', ['code'=>$request->code]);
    }

    /**
     * Holiday offers page
     * @return render view
     */
    public function holidayoffers(Request $request)
    {
        $active = 1;
        $limit = 10;
        $itineraries = §::with('itineraryimage', 'countries', 'offer')
                ->whereHas('offer', function ($query) use ($active) {
                    $query->where('active', $active);
                })
                ->orderBy('updated_at', 'DESC')->paginate($limit);

        return view('pages.holidays', [
            'name' => "Holiday Offers",
            'countries' => $this->getCountries(), // PagesTrait
            'itineraries' => $itineraries
        ]);
    }

    /**
     * Holidays page
     * @return render view
     */
    public function holidays(Request $request, $countryUrl = '')
    {
        $limit = 2;
        //DB::enableQueryLog();
        $order = ($request->has('o')?$request->o:'');
        $stars = ($request->has('s')?$request->s:'');

        $query = Itinerary::query();
        if ($stars != "") {
            $query = $query->where('stars', '=', $stars);
        }
        if ($order == "") {
            $query = $query->orderBy('updated_at', 'DESC');
        } else {
            switch ($order) {
                case 'p':
                    $query = $query->orderBy('price', 'ASC');
                    break;

                case 't':
                    $query = $query->orderBy('title', 'ASC');
                    break;

                case 'r':
                    $query = $query->orderBy('featured', 'DESC');
                    break;

                default:
                    $query = $query->orderBy('updated_at', 'DESC');
                    break;
            }
        }

        $query = $query->with('itineraryimage', 'countries')->where('active', '=', 1);
        if ($countryUrl != "") {
            $query = $query->whereHas('countries', function ($query) use ($countryUrl) {
                            $query->where('url', '=', $countryUrl);
            });
        }
        $itineraries = $query->paginate($limit);

        //dd(DB::getQueryLog());
        //dd($itineraries);
        if ($countryUrl != "") {
            $carousel = $this->getCarousel($countryUrl);
        } else {
            $carousel = '';
        }
        return view('pages.holidays', [
            'name' => "Holiday Tours",
            'countries' => $this->getCountries(), // PagesTrait
            'country' => $this->getCountry($countryUrl),
            'itineraries' => $itineraries,
            'carousel'=>$carousel,
            'countryUrl' => $countryUrl,
            'stars' => $stars,
            'order' => $order
        ]);
    }

    /**
     * Itineraries list page
     * @return render view
     */
    public function itinerary(Request $request, $itineraryUrl)
    {
        $pageTitle = "Skybourne - Holiday Itinerary";
        $itinerary = Itinerary::with('itineraryimages', 'countries', 'itinerarydays')
                ->where('url', '=', $itineraryUrl)
                ->where('active', '=', 1)
                ->first();
        //dd($itinerary);
        if (isset($itinerary->title) && $itinerary->title != "") {
            $pageTitle = $itinerary->title;
        }
        if (isset($itinerary->countries) && count($itinerary->countries) == 1) {
            $aCountry = $itinerary->countries->toArray();
            $country = $this->getCountry("", $aCountry[0]['id']);
        } else {
            $country = '';
        }

        if ($request->isMethod('POST')) {
            $rules = [
                    'customername' => 'required|max:255',
                    'phone' => 'required|min:10|max:15',
                    'email' => 'required|email',
                    'message' => 'required|min:10',
                ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('pages.itinerary', [
                    'name' => "Itinerary",
                    'pageTitle' => $pageTitle,
                    'countries' => $this->getCountries(),
                    'country' => $country,
                    'itinerary' => $itinerary,
                    'errors' => $validator->errors()
                ]);
            }

            $repoMessage = new MessagesRepository();
            $name = ($request->customername?$request->customername:"");
            $telephone = ($request->phone?$request->phone:"");
            $email = ($request->email?$request->email:"");
            $address = ($request->address?$request->address:"");
            $message = ($request->message?$request->message:"");

            $layout = 'emails.itineraryEnquire';
            $subject = "Skybourne - Itinerary Enquiry";
            $from = \Config::get('mail.from');
            $senderemail = $from['address'];
            $sendername = $from['name'];
            $sendernameinbody = "";
            $replyto = $aCC = $aBCC = [];
            $attachmentFile = "";
            $sendtoemail = $repoMessage->_companycustomerqueriesemail["email"];
            $sendtoname = $repoMessage->_companycustomerqueriesemail["name"];
            $data['data'] = ['name'=>$name, 'telephone'=>$telephone, 'email'=>$email, 'message'=>$message];

            $response = $repoMessage->sendmail($subject, $layout,   $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto, $aCC, $aBCC, $attachmentFile);

            if (isset($response[0]) && ($response[0] == true)) {
                return view('pages.itinerary', [
                        'success' => "Your message has been sent to Skybourne Travels.",
                        'name' => "Itinerary",
                        'pageTitle' => $pageTitle,
                        'countries' => $this->getCountries(),
                        'country' => $country,
                        'itinerary' => $itinerary
                    ]);
            } else {
                return view('pages.itinerary', [
                        'errors' => ["Something went wrong! Your itinerary enquiry has not been sent to Skybourne Travels."],
                        'name' => "Itinerary",
                        'pageTitle' => $pageTitle,
                        'countries' => $this->getCountries(),
                        'country' => $country,
                        'itinerary' => $itinerary
                    ]);
            }
        }

        return view('pages.itinerary', [
            'name' => "Itinerary",
            'pageTitle' => $pageTitle,
            'countries' => $this->getCountries(),
            'country' => $country,
            'itinerary' => $itinerary
        ]);
    }

    /**
     * Hotels list page
     * @return render view
     */
    public function hotels(Request $request, $countryUrl = '')
    {
        $limit = 2;
        //DB::enableQueryLog();
        if ($countryUrl == "") {
            $hotels = Hotel::with('facilities', 'hotelimage', 'country')
                    ->where('active', '=', 1)
                    ->orderBy('updated_at', 'DESC')->paginate($limit);
        } else {
            $hotels = Hotel::with('facilities', 'hotelimage', 'country')
                    ->whereHas('country', function ($query) use ($countryUrl) {
                            $query->where('url', '=', $countryUrl);
                    })
                    ->where('active', '=', 1)
                    ->orderBy('updated_at', 'DESC')->paginate($limit);
        }

        //dd(DB::getQueryLog());
        //dd($hotels);
        if ($countryUrl != "") {
            $carousel = $this->getCarousel($countryUrl);
        } else {
            $carousel = '';
        }

        return view('pages.hotels', [
            'name' => "Hotels",
            'countries' => $this->getCountries(), // PagesTrait
            'facilities' => $this->getHotelFacilities(), // PagesTrait
            'hotels' => $hotels,
            'country' => $this->getCountry($countryUrl),
            'carousel'=>$carousel
        ]);
    }

    /**
     * Hotel details page
     * @return render view
     */
    public function hotel(Request $request, $hotelUrl)
    {
        $pageTitle = "Skybourne - Hotel";
        $hotel = Hotel::with('facilities', 'hotelimages', 'country')
                ->where('url', '=', $hotelUrl)
                ->where('active', '=', 1)
                ->first();
        //dd($hotel);
        if (isset($hotel->name) && $hotel->name != "") {
            $pageTitle = $hotel->name;
        }
        return view('pages.hotel', [
            'name' => "Hotel",
            'pageTitle' => $pageTitle,
            'countries' => $this->getCountries(), // PagesTrait
            'facilities' => $this->getHotelFacilities(), // PagesTrait
            'hotel' => $hotel,
            'country' => (isset($hotel->country)?$hotel->country:'')
        ]);
    }

    /**
     * Flight search results
     * @return render view
     */
    public function searchresults(Request $request)
    {
        try {
            $request->flash();
            $data = [];
            return view('pages.results', $data);
        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Flight search results page - Calling Instaflight API
     * Tempory flight results holding page
     * @return render view
     */
    public function flightresultsInstaflights(Request $request)
    {
        try {
            $request->flash();
            if ($request->isMethod('POST')) {
                $rules = [  'flying_from' => 'required|min:3|max:3',
                            'flying_to' => 'required|min:3|max:3',
                            'departure_date' => 'required|after:' . date('Y-m-d') . '|date_format:Y-m-d',
                            'adults' => 'required|min:1|max:10'
                    ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return redirect('/')
                                ->withInput()
                                ->withErrors($validator->errors());
                }

                $searchtype = ($request->rbtn_searchtype?$request->rbtn_searchtype:"");
                $originPort = ($request->flying_from?$request->flying_from:""); // LHR
                $destinationPort = ($request->flying_to?$request->flying_to:"");  // CMB
                $departureDate = ($request->departure_date?$request->departure_date:""); // 2017-10-10
                $returnDate = ($request->return_date?$request->return_date:""); // 2017-10-15
                $passengercount = ($request->adults?$request->adults:1);
                $includedcarriers = ($request->slct_airline?$request->slct_airline:""); //includedcarriers=FI
                $excludedcarriers = ""; //excludedcarriers=TP
                $sortby = "totalfare";
                $order = "asc";
                $limit = 30;
                $offset = 1;
                $sortby2 = "";
                $order2 = "";

                $flexi = ($request->rbtn_flexi?$request->rbtn_flexi:0);
                $directonly = ($request->rbtn_directonly?$request->rbtn_directonly:0);

                $o = new Sabrecall();
                //$return = $o->searchFlight($originPort, $destinationPort, $departureDate, $returnDate, $passengercount);
                $flights = $o->instantFlightSearch(
                    $originPort,
                    $destinationPort,
                    $departureDate,
                    $returnDate,
                    $passengercount,
                    $includedcarriers,
                    $excludedcarriers,
                    $limit,
                    $offset,
                    $sortby,
                    $order,
                    $sortby2,
                    $order2
                );

                return view('pages.flightresultschathura', [
                    'name' => "Flight Results",
                    'flights' => $flights,
                    'rbtn_searchtype' => $searchtype,
                ]);
            }
            return view('pages.flightresults', [
                    'name' => "Flight Results",]);
        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Flight search results page - Calling BargainMax API
     * @return render view
     */
    public function flightresults(Request $request)
    {
        try {
            $request->flash();
            $response = $params = $summary = [];
            $searchtype = "";
            if ($request->isMethod('POST')) {
                $rules = [  'flying_from' => 'required|min:3|max:3',
                            'flying_to' => 'required|min:3|max:3',
                            'departure_date' => 'required|after:' . date('Y-m-d') . '|date_format:Y-m-d',
                            'adults' => 'required|min:1|max:10'
                    ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return redirect('/')
                                ->withInput()
                                ->withErrors($validator->errors());
                }

                $searchtype = ($request->rbtn_searchtype?$request->rbtn_searchtype:"");
                $originPort = ($request->flying_from?$request->flying_from:""); // LHR
                $destinationPort = ($request->flying_to?$request->flying_to:"");  // CMB
                $departureDate = ($request->departure_date?$request->departure_date:""); // 2017-10-10
                $returnDate = ($request->return_date?$request->return_date:""); // 2017-10-15
                $multiCity = [];
                if ($request->has('multicity') && is_array($request->multicity)) {
                    foreach ($request->multicity as $mc) {
                        if (isset($mc['origin']) && trim($mc['origin']) != ""
                                && isset($mc['destination']) && trim($mc['destination']) != ""
                                && isset($mc['departureDate']) && trim($mc['departureDate']) != "") {
                            $multiCity[] = ['origin'=>$mc['origin'],
                                            'destination'=>$mc['destination'],
                                            'departureDate'=>$mc['departureDate']
                                ];
                        }
                    }
                }
                /*$multiCity = [0=>['origin'=>"LHR",'destination'=>"CDG",'departureDate'=>"2017-10-22"],
                            1=>['origin'=>"CDG",'destination'=>"LIS",'departureDate'=>"2017-10-25"],
                            2=>['origin'=>"LIS",'destination'=>"MAN",'departureDate'=>"2017-10-28"]];*/
                $passengers = [
                    'adult' => ($request->adults?$request->adults:1),
                    'child'=>($request->child?$request->child:0),
                    'infant'=>($request->infant?$request->infant:0)
                ];

                $limit = 30;
                $offset = 1;
                $directFlightsOnly = ($request->has('rbtn_directonly')?($request->rbtn_directonly == 1?true:true):false);
                $flexiDays = ($request->has('rbtn_flexi')?($request->rbtn_flexi == 1?true:true):false);
                $onlyThisAirline = ($request->has('slct_airline')?$request->slct_airline:"");
                $class = ($request->has('slct_class')?$request->slct_class:"");
                $transferTime = ["min"=>'', "max"=>''];
                $poscountrycode = "GB";

                $o = new Sabrecall();
                $response = $o->bargainMaxFlightSearch(
                    $originPort,
                    $destinationPort,
                    $departureDate,
                    $returnDate,
                    $multiCity,
                    $passengers,
                    $limit,
                    $offset,
                    $directFlightsOnly,
                    $flexiDays,
                    $onlyThisAirline,
                    $class,
                    $transferTime,
                    $poscountrycode
                );

                $params = (isset($response['params'])?$response['params']:[]);  // search params
                $summary = (isset($response['summaryValues'])?$response['summaryValues']:[]); // summary of results. Data to left panel
                unset($response['params']);
                unset($response['summaryValues']);
                //Storage::disk('upload')->put('bfm-response-2.json', json_encode($response));
                return view('pages.flightresults', [
                    'name' => "Flight Results",
                    'results' => $response,
                    'params' => $params,
                    'summary' => $summary,
                    'rbtn_searchtype' => $searchtype,
                ]);
            }
            return view('pages.flightresults', [
                    'name' => "Flight Results",
                    'results' => $response,
                    'params' => $params,
                    'summary' => $summary,
                    'rbtn_searchtype' => $searchtype]);
        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Calling createPNR API
     * $this->createPNR(session('fbreqid'), $transactionId, $aItivalues['flightJournies'],
     *      $aItivalues['flightJournies'], $aItivalues['pricing']['ticketType'],
     *      $aSParams['passengers'], $passengersData, $status);
     * @return render view
     */
    private function createPNR(
        $customerId,
        $transactionId,
        $agencyInfo,
        $flightJournies,
        $ticketType,
        $passengers,
        $passengersData,
        $status,
        $currency
    ) {
        $o = new Sabrecall();
        $response = $o->createPNR($customerId, $transactionId, $agencyInfo, $flightJournies, $ticketType, $passengers, $passengersData, $status, $currency);
        return $response;
    }

    /**
     * Change date formate
     * @return render view
     */
    private function changeDate($dateInput)
    {
        return DateTime::createFromFormat('d/m/Y', $dateInput)->format('Y-m-d');
    }

    /**
     * Display the reserving flight journeies to confirm before make a payment
     * @param Request $request
     */
    public function flightJourniesConfirm(Request $request)
    {
        try {
            //$sItivalues = ($request->has('itivalues')?$request->itivalues:json_encode([]));
            //$sSearchparams = ($request->has('searchparams')?$request->searchparams:json_encode([]));

            // Decrypt the encrypted value
            $postAmount = ($request->has('amount')?$request->amount:0);
            $sItivalues = ($request->has('itivalues')?StringHelper::dencryptedString($request->itivalues):json_encode([]));
            $sSearchparams = ($request->has('searchparams')?StringHelper::dencryptedString($request->searchparams):json_encode([]));
            //var_dump($sSearchparams);
            $aSParams = json_decode($sSearchparams);
            $aItivalues = json_decode($sItivalues, true);

            // Check hacked
            if(!isset($aItivalues['pricing']['totalAmount']) || (isset($aItivalues['pricing']['totalAmount']) && $postAmount != $aItivalues['pricing']['totalAmount'])){
                return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
            }

            //echo '<pre>';print_r(json_decode($sItivalues));echo '</pre>';
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");
            return view('pages.selectedflight', [
                'name' => "Flight Details",
                'itivalues' => json_decode($sItivalues),
                'searchparams' => json_decode($sSearchparams),
                'currencySymbol' => $currencySymbol
            ]);

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Get booking passengers details
     * @param Request $request
     * @return Response
     */
    public function bookingPerson(Request $request)
    {
        try {
            $request->flash();
            /*if ($this->isRestrictedIp($request)) {
                return redirect('/')->with('error', 'Flight booking service temporarily unavailable!');
            }*/

            //$sItivalues = ($request->has('itivalues')?$request->itivalues:json_encode([]));
            //$sSearchparams = ($request->has('searchparams')?$request->searchparams:json_encode([]));
            //$aSParams = json_decode($sSearchparams);

            // Decrypt the encrypted value
            $postAmount = ($request->has('amount')?$request->amount:0);
            $sItivalues = ($request->has('itivalues')?StringHelper::dencryptedString($request->itivalues):json_encode([]));
            $sSearchparams = ($request->has('searchparams')?StringHelper::dencryptedString($request->searchparams):json_encode([]));

            $aSParams = json_decode($sSearchparams);
            $aItivalues = json_decode($sItivalues, true);
            //echo '<pre>'; print_r($aItivalues); die();
            // Check hacked
            if(!isset($aItivalues['pricing']['totalAmount']) || (isset($aItivalues['pricing']['totalAmount'])
                    && $postAmount != $aItivalues['pricing']['totalAmount'])){
                return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
            }

            //echo '<pre>';print_r(json_decode($sItivalues));echo '</pre>';
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");
            if ($request->isMethod('POST') && $request->has('_personal')) {
                $validator = Validator::make($request->all(), [
                    'title.*' => 'required|in:Mr,Mrs,Miss,Dr,Rev',
                    'firstName.*' => 'required|max:255',
                    'lastName.*' => 'required|max:255',
                    'dateOfBirth.*' => 'required|before:' . date('d/m/Y') . '|date_format:d/m/Y',
                    'gender.*' => 'required|max:10',
                    'email' => 'required|email',
                    //'passportNumber' => 'required',
                    //'country' => 'required',
                    //'nationality' => 'required',
                    //'passportExpiryDate' => 'required',
                ]);

                if ($validator->fails()) {
                    //$validator->errors()->add('country', 'Passport issued country');

                    return view('pages.bookingpersonal', [
                        'name' => "Personal Details",
                        'errors'=>$validator->errors(),
                        'sItivalues' => $sItivalues,
                        'sSearchparams' => $sSearchparams,
                        'currencySymbol' => $currencySymbol
                    ]);
                }


                $title = ($request->has('title')?$request->title:[]);
                $firstname = ($request->has('firstName')?$request->firstName:[]);
                $lastname = ($request->has('lastName')?$request->lastName:[]);
                $email = ($request->has('email')?$request->email:[]);
                $gender = ($request->has('gender')?$request->gender:[]);
                $phone = ($request->has('phoneNo')?$request->phoneNo:[]);
                $dob = ($request->has('dateOfBirth')?$request->dateOfBirth:[]);
                $passportno = ($request->has('passportNumber')?$request->passportNumber:[]);
                $issuecountry = ($request->has('issuecountry')?$request->issuecountry:[]);
                $expiredate = ($request->has('passportExpiryDate')?$request->passportExpiryDate:[]);
                $nationality = ($request->has('nationality')?$request->nationality:[]);
                $passengerType = ($request->has('passengerType')?$request->passengerType:[]);
                $id = 0;

                $bookingData = [
                    'name' => (isset($title[0])?$title[0]." ":"").(isset($firstname[0])?$firstname[0]." ":"").(isset($lastname[0])?$lastname[0]:""),
                    'email' => $request->email,
                    'gender' => $gender[0],
                    'phone' => $phone,
                    'dob' => $dob[0],
                    'flight' => [
                        'price' => $aItivalues['pricing']['totalAmount'],
                        'currency' => $aItivalues['pricing']['currency'],
                        'ticketAirlineName' => $aItivalues['pricing']['ticketAirlineName'],
                        'cabinClass' => $aItivalues['pricing']['cabinClass'],
                    ]
                ];

                $bookingData['flight']['flightJournies'] = [
                        0 => [
                                'originAirport' => $aItivalues['flightJournies'][0]['originAirport'],
                                'departureTime' => $aItivalues['flightJournies'][0]['departureTime'],
                                'destinationAirport' => $aItivalues['flightJournies'][0]['destinationAirport'],
                                'arrivalTime' => $aItivalues['flightJournies'][0]['arrivalTime'],
                            ]
                ];

                if(count($aItivalues['flightJournies']) > 1){
                    $x = (count($aItivalues['flightJournies'])-1);
                    $bookingData['flight']['flightJournies'][1] = [
                                'originAirport' => $aItivalues['flightJournies'][$x]['originAirport'],
                                'departureTime' => $aItivalues['flightJournies'][$x]['departureTime'],
                                'destinationAirport' => $aItivalues['flightJournies'][$x]['destinationAirport'],
                                'arrivalTime' => $aItivalues['flightJournies'][$x]['arrivalTime'],
                            ];
                }

                DB::transaction(function () use (
                    $request,
                    $passengerType,
                    $title,
                    $firstname,
                    $lastname,
                    $email,
                    $gender,
                    $phone,
                    $dob,
                    $passportno,
                    $issuecountry,
                    $expiredate,
                    $nationality,
                    $sItivalues,
                    $sSearchparams
                ) {
                    $temp_trnid = str_replace('.', '', microtime(true));
                    //dd('--2--;'.$trnid);
                    $fbreq = new Flightbookingrequest;
                    //'user_id', 'type', 'title', 'firstname', 'lastname', 'email', 'gender', 'phone', 'dob', 'passportno', 'issuecountry',
                    //'expiredate', 'nationality'
                    $fbreq->status = "REQUEST";
                    $fbreq->transactionid = $temp_trnid;
                    $fbreq->title = $title[0];
                    $fbreq->firstname = $firstname[0];
                    $fbreq->lastname = $lastname[0];
                    $fbreq->gender = $gender[0];
                    $fbreq->dob = $this->changeDate($dob[0]);
                    $fbreq->passportno = $passportno[0];
                    $fbreq->issuecountry = $issuecountry[0];
                    $fbreq->expiredate = $expiredate[0];
                    $fbreq->nationality = $nationality[0];
                    $fbreq->email = $email;
                    $fbreq->phone = $phone;
                    $fbreq->itivalues = $sItivalues;
                    $fbreq->searchparams = $sSearchparams;
                    $fbreq->save();
                    $id = $fbreq->id;

                    // Get correct transaction id
                    $now = new \DateTime();
                    $trnid = "FB".  $now->format('ymd').$temp_trnid = str_pad(substr($id, -4), 4, '0', STR_PAD_LEFT);
                    $fbreq->transactionid = $trnid;
                    $fbreq->save();
                    $this->setTransactionId($trnid);
                    session(['fbreqid' => $id]);

                    // Save passengers details
                    $count = count($firstname);

                    if (is_array($firstname) && count($firstname) == count($title) && count($firstname) == count($lastname)) {
                        for ($x = 0; $x<=($count-1); $x++) {
                            $passenger = Passengers::create([
                                            'type' => $passengerType[$x],
                                            'title' => $title[$x],
                                            'firstname'  => $firstname[$x],
                                            'lastname' => $lastname[$x],
                                            'gender' => $gender[$x],
                                            'dob' => $this->changeDate($dob[$x]),
                                            'passportno' => $passportno[$x],
                                            'issuecountry' => $issuecountry[$x],
                                            'expiredate' => $expiredate[$x],
                                            'nationality' => $nationality[$x],
                                            'email' => ($x == 0?$email:''),
                                            'phone' => ($x == 0?$phone:'')
                                        ]);

                            $fbreq->passengers()->save($passenger);
                        }
                    }
                });

                //return redirect('/booking/payment');
                //echo "<pre>"; print_r($bookingData); die();
                //array_merge($bookingData, $_POST);
                $mailresponse = $this->sendBookingDetailEmail($bookingData);
                if ($mailresponse[0] === true) {

                    return view('pages.paymentresponse', [
                        'name' => "Flight booking request sent.",
                        'response' => "success",
                        'message' => "Thank you for booking with Skybourne Travels. "
                        . "<br/><br/>A member of our team will be in touch within the next 24 hours to complete your booking. If your booking is urgent please contact us on 02039504636 during business hours. <br/><br/>"
                    ]);
                }
            }
            return view('pages.bookingpersonal', [
                'name' => "Personal Details",
                'sItivalues' => $sItivalues,
                'sSearchparams' => $sSearchparams,
                'currencySymbol' => $currencySymbol
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            /*
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();*/
        }
    }

    /**
     * Make payment page - call just before connecting to PG
     * @param Request $request
     * @return Response
     */
    public function makePayment(Request $request)
    {
        try {
            $id = session('fbreqid');
            if ($id <= 0) {
                return redirect('/')->with('error', 'Your session has been expired! Please try to find a flight again.');
            }

            $reqip = $request->ip();
            $fbreq = Flightbookingrequest::find($id);

            $aSParams = json_decode($fbreq['searchparams']);
            $itivalues = json_decode($fbreq['itivalues']);
            $currencyCode = isset($aSParams->currencycode)?$aSParams->currencycode:"";
            $currencySymbol = $this->getCurrencySymbol($currencyCode);

            // PNR create should be goes here
            $pnrResponse = $this->callPNRCreate($fbreq);
            if ($pnrResponse[0] !== true) {
                return view('pages.paymentresponse', [
                        'name' => "Flight booking not success",
                        'response' => "fail",
                        'message' => "System error occured! Your flight booking was not success."
                    ]);
            }

            // Proceed to payment
            //- Customer/Order Details - //
            $UserTitle      =   $fbreq['title']; //"Mr";
            $UserFirstname  =   $fbreq['firstname']; //"Edward";
            $UserSurname    =   $fbreq['lastname']; //"Shopper";
            $BillHouseNumber=   ""; //"123";
            $Ad1            =   ""; //"Penny Lane";
            $Ad2            =   ""; //"Central Areas";
            $BillTown       =   ""; //"Middlehampton";
            $BillCountry    =   ""; //"England";
            $Pcde           =   ""; //"NN4 7SG";
            $ContactTel     =   $fbreq['phone']; //"01604 567 890";
            $ShopperEmail   =   $fbreq['email']; //"Mr.E.Shopper@coolmail.com";
            $ShopperLocale  =   "en_GB";
            $CurrencyCode   =   $currencyCode; //"GBP";

            $Addressline1n2 = trim($BillHouseNumber . " " .$Ad1 . ($Ad2 != ""? ", ". $Ad2:""));
            $CustomerName   = $UserTitle . " " . $UserFirstname . " " . $UserSurname;
            /* TESTING PG
            if($reqip == "82.31.135.239"){
                $itivalues->pricing->totalAmount = 0.02;
            } */
            $PaymentAmount  = (100 * $itivalues->pricing->totalAmount);         // this is 1 pound (100p)
            $OrderDataRaw   = "Flight Booking";     // order description
            $OrderID        = $fbreq['transactionid'];              // Order Id - needs to be unique

            //- integration user details - //
            $PW             = \Config::get('bpg.PASSWORD'); //"MyShaInPassPhrase" | skymerchant@2017!%* | skymerchant@2017;
            $PSPID          = \Config::get('bpg.SESSIONID'); //"MyPSPID" | epdq6023566 | epdqtest6023566 | ;

            //- payment design options - //
            $TXTCOLOR       =   "#005588";
            $TBLTXTCOLOR    =   "#005588";
            $FONTTYPE       =   "Helvetica, Arial";
            $BUTTONTXTCOLOR =   "#005588";
            $BGCOLOR        =   "#d1ecf3";
            $TBLBGCOLOR     =   "#ffffff";
            $BUTTONBGCOLOR  =   "#cccccc";
            $TITLE          =   "Skybourne - Secure Payment Page";
            $LOGO           =   \Config::get('bpg.LOGOURL');
            $PMLISTTYPE     =   1;

            //= create string to hash (digest) using values of options/details above
            $DigestivePlain =
            "AMOUNT=" . $PaymentAmount . $PW .
            "BGCOLOR=" . $BGCOLOR . $PW .
            "BUTTONBGCOLOR=" . $BUTTONBGCOLOR . $PW .
            "BUTTONTXTCOLOR=" . $BUTTONTXTCOLOR . $PW .
            "CN=" . $CustomerName  . $PW .
            "COM=" . $OrderDataRaw  . $PW .
            "CURRENCY=" . $CurrencyCode . $PW .
            "EMAIL=" . $ShopperEmail . $PW .
            "FONTTYPE=" . $FONTTYPE . $PW .
            "LANGUAGE=" . $ShopperLocale . $PW .
            "LOGO=" .$LOGO . $PW .
            "ORDERID=" . $OrderID . $PW .
            "OWNERADDRESS=" . $Addressline1n2 . $PW .
            "OWNERCTY=" . $BillCountry . $PW .
            "OWNERTELNO=" . $ContactTel . $PW .
            "OWNERTOWN=" . $BillTown . $PW .
            "OWNERZIP=" . $Pcde . $PW .
            "PMLISTTYPE=". $PMLISTTYPE . $PW .
            "PSPID=" . $PSPID . $PW .
            "TBLBGCOLOR=" . $TBLBGCOLOR . $PW .
            "TBLTXTCOLOR=" . $TBLTXTCOLOR . $PW .
            "TITLE=" . $TITLE . $PW .
            "TXTCOLOR=" . $TXTCOLOR . $PW .
            "";
            $DigestivePlain =
                "AMOUNT=" . $PaymentAmount . $PW .
                "CURRENCY=" . $CurrencyCode . $PW .
                "LANGUAGE=" . $ShopperLocale . $PW .
                "ORDERID=" . $OrderID . $PW .
                "PSPID=" . $PSPID . $PW .
                "";

            //=SHA encrypt the string=//
            $strHashedString_plain = strtoupper(sha1($DigestivePlain));
            //echo "DP: ".$DigestivePlain."<br/>";
            //echo "Hash: ".$strHashedString_plain."<br/>";
            //dd();
            return view('pages.makepayment', [
                'reqip' => $reqip,
                'name' => "Make a payment",
                'sItivalues' => $fbreq['itivalues'],
                'sSearchparams' => $fbreq['searchparams'],
                'currencySymbol' => $currencySymbol,
                'title' => $fbreq['title'],
                'firstname' => $fbreq['firstname'],
                'lastname' => $fbreq['lastname'],
                'email' => $fbreq['email'],
                'phone' => $fbreq['phone'],
                'orderid' => $fbreq['transactionid'],

                "PaymentAmount" => $PaymentAmount,
                "CustomerName" => $CustomerName ,
                "OrderDataRaw" => $OrderDataRaw ,
                "CurrencyCode" => $CurrencyCode ,
                "ShopperEmail" => $ShopperEmail ,
                "FONTTYPE" => $FONTTYPE ,
                "ShopperLocale" => $ShopperLocale ,
                "LOGO" => $LOGO ,
                "OrderID" => $OrderID ,
                "Addressline1n2" => $Addressline1n2 ,
                "BillCountry" => $BillCountry ,
                "ContactTel" => $ContactTel ,
                "BillTown" => $BillTown ,
                "Pcde" => $Pcde ,
                "PMLISTTYPE" => $PMLISTTYPE ,
                "PSPID" => $PSPID ,
                "BGCOLOR" => $BGCOLOR ,
                "BUTTONBGCOLOR" => $BUTTONBGCOLOR ,
                "BUTTONTXTCOLOR" => $BUTTONTXTCOLOR ,
                "TBLBGCOLOR" => $TBLBGCOLOR ,
                "TBLTXTCOLOR" => $TBLTXTCOLOR ,
                "TITLE" => $TITLE ,
                "TXTCOLOR" => $TXTCOLOR ,

                'strHashedString_plain' => $strHashedString_plain,
            ]);
        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Catch the PG response
     * @param Request $request
     * @param string $response
     * @return Response
     */
    public function paymentResponse(Request $request, $response)
    {
        try {
            $request->flash();
            $paymentid = 0;

            if (!$request->has("amount") || !$request->has("orderID")) {
                return view('pages.paymentresponse', [
                        'name' => "Payment not successful!",
                        'response' => "fail",
                        'message' => "Payment details missing!"
                    ]);
            }

            $type = substr($request->orderID, 0, 2);
            if ($type === "FB") {
                return $this->flightbookingPaymentResponse($request, $response);
            } else {
                return $this->directPaymentResponse($request, $response);
            }
        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Flight booking PG response handling function
     * @param Request $request
     * @param string $response
     * @return Response
     */
    public function flightbookingPaymentResponse(Request $request, $response)
    {
        try {
            //echo "res:$response<br/>";

            //orderID=12215088833525402&currency=GBP&amount=471.47
            //&PM=CreditCard&ACCEPTANCE=test123
            //&STATUS=5
            //&CARDNO=XXXXXXXXXXXX4444
            //&ED=0818&CN=S+K+MUNASINGHE&TRXDATE=10%2F24%2F17
            //&PAYID=3026468722&PAYIDSUB=0&NCERROR=0&BRAND=MasterCard&IPCTY=GB&CCCTY=99
            //&ECI=7&CVCCheck=NO
            //&AAVCheck=NO&VC=NO&IP=82.31.135.239
            //&SHASIGN=3E84C8BD0854D0F104B1BA92234EAEA9CE7FCCCE
            $request->flash();
            $paymentid = 0;

            if (!($request->has("amount") && $request->has("orderID"))) {
                return view('pages.paymentresponse', [
                        'name' => "Flight booking not success",
                        'response' => "fail",
                        'message' => "Payment details missing!"
                    ]);
            }

            DB::transaction(function () use ($request, &$paymentid) {
                $orderid = $request->has("orderID")?$request->orderID:"";
                // Check attempts
                //$attempts = Cardpayments::where("orderid", "=", $orderid)->count();
                $get = Cardpayments::where("orderid", "=", $orderid)->first();

                if ($get !== null) {
                    $paymentid = $get->id;
                    Cardpayments::where("orderid", "=", $orderid)
                        ->update(['attempts' => ($get->attempts+1)]);
                } else {
                    $cpay = new Cardpayments;
                    $cpay->orderid = $orderid;
                    $cpay->currency = $request->has("currency")?$request->currency:"";
                    $cpay->amount = $request->has("amount")?$request->amount:"";
                    $cpay->paymethod = $request->has("PM")?$request->PM:"";
                    $cpay->acceptance = $request->has("ACCEPTANCE")?$request->ACCEPTANCE:"";
                    $cpay->statuscode = $request->has("STATUS")?$request->STATUS:"";
                    $cpay->cardno = $request->has("CARDNO")?$request->CARDNO:"";
                    $cpay->cexpd = $request->has("ED")?$request->ED:"";
                    $cpay->cname = $request->has("CN")?$request->CN:"";
                    $cpay->trxdate = $request->has("TRXDATE")?$request->TRXDATE:"";
                    $cpay->payid = $request->has("PAYID")?$request->PAYID:"";
                    $cpay->ncerror = $request->has("NCERROR")?$request->NCERROR:"";
                    $cpay->brand = $request->has("BRAND")?$request->BRAND:"";
                    $cpay->ipcty = $request->has("IPCTY")?$request->IPCTY:"";
                    $cpay->cccty = $request->has("CCCTY")?$request->CCCTY:"";
                    $cpay->eci = $request->has("ECI")?$request->ECI:"";
                    $cpay->cvccheck = $request->has("CVCCheck")?$request->CVCCheck:"";
                    $cpay->ip = $request->has("IP")?$request->IP:"";
                    $cpay->attempts = 1;
                    $cpay->save();
                    $paymentid = $cpay->id;
                }
            });

            $transactionId = $request->has("orderID")?$request->orderID:($request->has("ORDERID")?$request->ORDERID:"");

            $id = Session::get('fbreqid');
            if ($id === null || !($id > 0)) {
                if($transactionId != ""){
                    $trnfbreq = Flightbookingrequest::where('transactionid', '=', $transactionId)
                            ->where('status', '=', 'PNR_RESPOND')->first();
                    $id = $trnfbreq->id;
                    if($id === null || !($id > 0)){
                        return redirect('/')->with('error', 'Your session has been expired! Please try to find a flight again.');
                    }
                } else {
                    return redirect('/')->with('error', 'Your session has been expired! Please try to find a flight again.');
                }
            }
            // Clear session value to stop refresh the page / Explicitly change url and trigger success email
            Session::forget('fbreqid');

            // Update payments table with flightbooking id--
            $fbreq = Flightbookingrequest::find($id);
            $cpayment = Cardpayments::find($paymentid);
            $cpayment->cardpayable_type = 'flightbookingrequests';
            $cpayment->cardpayable_id = $id;
            $cpayment->save();
            //echo "trn:".$transactionId."<br/>id:".$id." dbtrn:".$fbreq['transactionid'];

            if (!isset($fbreq['transactionid']) || $fbreq['transactionid'] != $transactionId) {
                $message = "Some issue was arose while processing your transaction. So, your flight booking has not been confirmed. Please contact Skybourne.";
                return view('pages.paymentresponse', [
                        'name' => "Flight booking not success",
                        'response' => "fail",
                        'message' => $message
                    ]);
            }

            $pg_status = "";
            switch ($response) {
                case 'success':
                    $fbreq->status = $pg_status = "PAYMENT_SUCCESS";
                    $message = "Your flight booking has been successfully proccessed.";
                    break;

                case 'decline':
                    $fbreq->status = $pg_status = "PAYMENT_DECLINE";
                    $message = "Your payment is declined. So, your flight booking has not been confirmed.";
                    break;

                case 'exception':
                    $fbreq->status = $pg_status = "PAYMENT_EXCEPTION";
                    $message = "Some issue was arose while processing your transaction. Your payment transaction has not success. So, your flight booking has not been confirmed.";
                    break;

                case 'canceled':
                    $fbreq->status = $pg_status = "PAYMENT_CANCELED";
                    $message = "You have cancelled the transaction while processing. So, your flight booking has not been confirmed.";
                    break;
            }

            /*
            // Get PNR
            $pnrResponse = array(0=>false);
            if ($response == "success") {
                // Get all passengers details
                $passengersData = Passengers::where('flightbookingrequests_id', '=', $fbreq->id)->get();
                $passengersData = $passengersData->toArray();

                // Create PNR
                $aSParams = json_decode($fbreq['searchparams'], true);
                $aItivalues = json_decode($fbreq['itivalues'], true);

                $status = "NN";
                $currency = "GBP";
                $ticketType = '7TAW'; // $aItivalues['pricing']['ticketType']
                $pnrResponse = $this->createPNR($id, $transactionId, $this->agencyAddress,
                        $aItivalues['flightJournies'], $ticketType, $aSParams['passengers'],
                        $passengersData, $status, $currency);
                // Save PNR code in DB
                $fbreq->pnr = $pnrResponse['itineraryRefId'];
                $fbreq->airlineresponse = $pnrResponse['airlineresponse'];
                $fbreq->pnrstatus = $pnrResponse['status'];
                $fbreq->pnrtimestamp = $pnrResponse['pnrtimestamp'];
            }*/

            // Update DB with payment status
            $fbreq->save();

            if ($response == "success") {
                    $mailresponse = $this->sendConfirmMail($id);
                if ($mailresponse[0] === true) {
                    return view('pages.paymentresponse', [
                        'name' => "Flight booking confirmed",
                        'response' => "success",
                        'message' => "Your flight booking has been successfully proccessed. "
                        . "You will recieve the confirmation email to ".$mailresponse['sendtoemail']."! <br/>"
                        . "Your booking reference is: ".$transactionId." "
                    ]);
                } else {
                    return view('pages.paymentresponse', [
                        'name' => "Booking confirm",
                        'response' => "success",
                        'message' => "Your flight booking has been successfully proccessed. "
                        . "But sending email process was not success to your given email !"
                        . "Your booking reference is: ".$transactionId." ",
                        'error' => ["Email not sent!"]
                    ]);
                }
            } else {
                $paymentResponse = [
                    'Response' => $pg_status,
                    'Currency' => $request->has("currency")?$request->currency:"",
                    'Amount' => $request->has("amount")?$request->amount:"",
                    'Status' => $request->has("STATUS")?$request->STATUS:"",
                    'CardNo' => $request->has("CARDNO")?$request->CARDNO:"",
                    'IP' => $request->has("IP")?$request->IP:"",
                ];
                $this->sendPaymentNotSuccessMail($fbreq, $paymentResponse);
                return view('pages.paymentresponse', [
                        'name' => "Flight booking not success",
                        'response' => "fail",
                        'message' => $message
                    ]);
            }

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Call to create PNR & update Flightbookingrequest table
     * @param DB collection $fbreq
     * @return array
     */
    private function callPNRCreate($fbreq)
    {
        try {
            // Update status in Flightbookingrequest table
            $fbreq->status = "PNR_REQUEST";
            $fbreq->save();

            // Get PNR
            $pnrResponse = array(0=>false);
            // Get all passengers details
            $passengersData = Passengers::where('flightbookingrequests_id', '=', $fbreq->id)->get();
            $passengersData = $passengersData->toArray();

            // Create PNR
            $aSParams = json_decode($fbreq['searchparams'], true);
            $aItivalues = json_decode($fbreq['itivalues'], true);

            $status = "NN";
            $currency = "GBP";
            $ticketType = '7TAW'; // $aItivalues['pricing']['ticketType']
            $pnrResponse = $this->createPNR(
                $fbreq->id,
                $fbreq->transactionid,
                $this->agencyAddress,
                $aItivalues['flightJournies'],
                $ticketType,
                $aSParams['passengers'],
                $passengersData,
                $status,
                $currency
            );

            // Save PNR code in DB
            $fbreq->pnr = $pnrResponse['itineraryRefId'];
            $fbreq->airlineresponse = $pnrResponse['airlineresponse'];
            $fbreq->pnrstatus = $pnrResponse['status'];
            $fbreq->pnrtimestamp = $pnrResponse['pnrtimestamp'];
            $fbreq->status = "PNR_RESPOND";

            // Update DB
            $fbreq->save();

            $this->pnrCreatedSendToSkywings($pnrResponse, $fbreq->id);
            return $pnrResponse;

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!');
        }
    }

    /**
     * Function for sending PNR response to Skywings
     * @param array $pnrResponse
     * @param int Flightbookingrequest ID
     */
    private function pnrCreatedSendToSkywings($pnrResponse, $flightbookingrequestId)
    {
        try {
            $fbreq = Flightbookingrequest::with('passengers', 'cardpayments')->find($flightbookingrequestId);
            $bookingRef = $fbreq->transactionid;
            $aItivalues = json_decode($fbreq->itivalues);
            $aSParams = json_decode($fbreq->searchparams);
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");

            // Send mail
            $oMsgRepo = new MessagesRepository();
            $layout = "emails.skywings-pnrresponse";
            $subject = "PNR created";
            $body = "This is PNR response email";
            $sendtoemail = $oMsgRepo->_bookingsemail['email'];
            $sendtoname = $oMsgRepo->_bookingsemail['name'];
            $sendernameinbody = "Skybourne Travels";
            $senderemail = $oMsgRepo->_defReplyto['email'];
            $sendername = $oMsgRepo->_defReplyto['name'];
            $replyto = $oMsgRepo->_defReplyto;
            $cc = [[$oMsgRepo->_companycustomerqueriesemail['email'], $oMsgRepo->_companycustomerqueriesemail['name']]];
            $bcc = "";
            $attachmentFile = "";
            $personalDetails = [];
            foreach ($fbreq->passengers as $passenger) {
                $personalDetails[] = ['title'=>$passenger->title, 'firstname'=>$passenger->firstname, 'lastname'=>$passenger->lastname,
                'email'=>$passenger->email, 'gender'=>$passenger->gender, 'phone'=>$passenger->phone, 'dob'=>$passenger->dob,
                'passportno'=>$passenger->passportno, 'issuecountry'=>$passenger->issuecountry, 'expiredate'=>$passenger->expiredate,
                'nationality'=>$passenger->nationality];
            }
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'bookingReference' => $bookingRef,
                'pnrResponse' => $pnrResponse,
                'personalDetails' => $personalDetails,
                'itivalues'=> $aItivalues,
                'withreturn' => ($aSParams->returndate != ""?true:false),
                'searchparams' => $aSParams,
                'currencySymbol' => $currencySymbol,
                'datetime' => date('y-m-d h:i:s') ];
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

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!');
        }
    }

    /**
     * Send booking confirmation email to both customer & Skybourne
     * @param int $flightBookingId
     * @return array
     */
    private function sendConfirmMail($flightBookingId)
    {
        try {
            $fbreq = Flightbookingrequest::with('passengers', 'cardpayments')->find($flightBookingId);
            $bookingRef = $fbreq->transactionid;
            $aItivalues = json_decode($fbreq->itivalues);
            $aSParams = json_decode($fbreq->searchparams);
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");

            // Send mail
            $oMsgRepo = new MessagesRepository();
            $layout = "emails.flightbooking";
            $subject = "Flight booking request";
            $body = "This is flight booking request email";
            $sendtoemail = $fbreq->email;
            $sendtoname = trim($fbreq->firstname.($fbreq->lastname != ""?" ".$fbreq->lastname:''));
            $sendernameinbody = "Skybourne Travels";
            $senderemail = $oMsgRepo->_bookingsemail['email'];
            $sendername = $oMsgRepo->_bookingsemail['name']; //trim($fbreq->firstname.($fbreq->lastname != ""?" ".$fbreq->lastname:''));
            $replyto = $oMsgRepo->_defReplyto;
            $cc = [[$oMsgRepo->_companycustomerqueriesemail['email'], $oMsgRepo->_companycustomerqueriesemail['name']]];
            $bcc = "";
            $attachmentFile = "";
            $personalDetails = [];
            foreach ($fbreq->passengers as $passenger) {
                $personalDetails[] = ['title'=>$passenger->title, 'firstname'=>$passenger->firstname, 'lastname'=>$passenger->lastname,
                'email'=>$passenger->email, 'gender'=>$passenger->gender, 'phone'=>$passenger->phone, 'dob'=>$passenger->dob,
                'passportno'=>$passenger->passportno, 'issuecountry'=>$passenger->issuecountry, 'expiredate'=>$passenger->expiredate,
                'nationality'=>$passenger->nationality];
            }
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'bookingReference' => $bookingRef,
                'personalDetails' => $personalDetails,
                'itivalues'=> $aItivalues,
                'withreturn' => ($aSParams->returndate != ""?true:false),
                'searchparams' => $aSParams,
                'currencySymbol' => $currencySymbol,
                'datetime' => date('y-m-d h:i:s') ];
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

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!');
        }
    }

    /**
     * Send booking not success email to both customer & Skybourne
     * @param int $flightBookingId
     * @return array
     */
    private function sendCreatePNRNotSuccessMail($fbreq, $pnrResponse)
    {
        try {
            $aItivalues = json_decode($fbreq->itivalues);
            $aSParams = json_decode($fbreq->searchparams);
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");

            // Send mail
            $oMsgRepo = new MessagesRepository();
            $layout = "emails.flightbookingerror";
            $subject = "Flight booking request - PNR Not generated";
            $sendtoemail = $oMsgRepo->_companycustomerqueriesemail['email'];
            $sendtoname = $oMsgRepo->_companycustomerqueriesemail['name'];
            $sendernameinbody = "Skybourne Travels";
            $senderemail = $oMsgRepo->_bookingsemail['email'];
            $sendername = trim($fbreq->firstname.($fbreq->lastname != ""?" ".$fbreq->lastname:''));
            $replyto = $oMsgRepo->_defReplyto;
            $cc = "";
            $bcc = "";
            $attachmentFile = "";
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'personalDetails' => ['title'=>$fbreq->title, 'firstname'=>$fbreq->firstname, 'lastname'=>$fbreq->lastname,
                'email'=>$fbreq->email, 'gender'=>$fbreq->gender, 'phone'=>$fbreq->phone, 'dob'=>$fbreq->dob,
                'passportno'=>$fbreq->passportno, 'issuecountry'=>$fbreq->issuecountry, 'expiredate'=>$fbreq->expiredate,
                'nationality'=>$fbreq->nationality],
                'itivalues'=> $aItivalues,
                'withreturn' => ($aSParams->returndate != ""?true:false),
                'searchparams' => $aSParams,
                'currencySymbol' => $currencySymbol,
                'datetime' => date('y-m-d h:i:s'),
                'errorData' => $pnrResponse];
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

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!');
        }
    }


    /**
     * Send booking not success email to both customer & Skybourne
     * @param int $flightBookingId
     * @return array
     */
    private function sendPaymentNotSuccessMail($fbreq, $paymentResponse)
    {
        try {
            $aItivalues = json_decode($fbreq->itivalues);
            $aSParams = json_decode($fbreq->searchparams);
            $currencySymbol = $this->getCurrencySymbol(isset($aSParams->currencycode)?$aSParams->currencycode:"");

            // Send mail
            $oMsgRepo = new MessagesRepository();
            $layout = "emails.flightbookingerror";
            $subject = "Flight booking request - PAYMENT NOT SUCCESS";
            $sendtoemail = $oMsgRepo->_companycustomerqueriesemail['email'];
            $sendtoname = $oMsgRepo->_companycustomerqueriesemail['name'];
            $sendernameinbody = "Skybourne Travels";
            $senderemail = $oMsgRepo->_defReplyto['email'];
            $sendername = $oMsgRepo->_defReplyto['name'];
            $replyto = $oMsgRepo->_defReplyto;
            $cc = "";
            $bcc = "";
            $attachmentFile = "";
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'personalDetails' => ['title'=>$fbreq->title, 'firstname'=>$fbreq->firstname, 'lastname'=>$fbreq->lastname,
                'email'=>$fbreq->email, 'gender'=>$fbreq->gender, 'phone'=>$fbreq->phone, 'dob'=>$fbreq->dob,
                'passportno'=>$fbreq->passportno, 'issuecountry'=>$fbreq->issuecountry, 'expiredate'=>$fbreq->expiredate,
                'nationality'=>$fbreq->nationality],
                'itivalues'=> $aItivalues,
                'withreturn' => ($aSParams->returndate != ""?true:false),
                'searchparams' => $aSParams,
                'currencySymbol' => $currencySymbol,
                'datetime' => date('y-m-d h:i:s'),
                'errorData' => $paymentResponse];
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

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!');
        }
    }

    /**
     * Confirm page
     * @param Request $request
     * @return Response
     */
    public function bookingConfirm(Request $request)
    {
        $request->flash();
        if ($request->isMethod('POST')) {
            //return redirect('/booking/confirm')->withInput();
        }
        return view('pages.bookingconfirm', [
            'name' => "Booking confirm"
        ]);
    }

    /**
     * Get currency symbol of given currency code
     * @param string $currencyCode
     * @return string
     */
    public function getCurrencySymbol($currencyCode)
    {
        switch ($currencyCode) {
            case 'GBP':
                return "£";
                break;
            case 'USD':
                return "$";
                break;
            default:
                return "£";
                break;
        }
    }

    /**
     * Direct payment page loading from emailed url
     * @param Request $request
     * @param string $token
     * @return Response
     */
    public function directPayment(Request $request, $token)
    {
        try {
            $dateTimeObj= new DateTime();
            $now = $dateTimeObj->format('Y-m-d H:i:s');
            $payreq = Paymentrequest::where('token', '=', $token)->where('expiredon', '>', $now)->first();
            if (!$payreq) {
                // unable to find the requested page. May be it has been expired
                return view('pages.paymentresponse', [
                        'name' => "Payment request",
                        'response' => "fail",
                        'message' => "Payment request has been expired!"
                    ]);
            }

            // Update the status
            $payreq->status = "CLICKED";
            $payreq->save();

            // save in session
            Session::set('dpreqid', $payreq->id);
            $currencyCode = "GBP";
            $currencySymbol = $this->getCurrencySymbol($currencyCode);

            // Set Payment gateway values
            $reqip = $request->ip();
            $dpreq = $payreq->toArray();
            $UserTitle      =   $dpreq['title'];
            $UserFirstname  =   $dpreq['firstname'];
            $UserSurname    =   $dpreq['lastname'];
            $BillHouseNumber=   "";
            $Ad1            =   $dpreq['adrsline1'];
            $Ad2            =   $dpreq['adrsline2'];
            $BillTown       =   $dpreq['town'];
            $BillCountry    =   $dpreq['country'];
            $Pcde           =   $dpreq['postcode'];
            $ContactTel     =   $dpreq['phone'];
            $ShopperEmail   =   $dpreq['email'];
            $ShopperLocale  =   "en_GB";
            $CurrencyCode   =   $currencyCode;

            $Addressline1n2 = trim($BillHouseNumber . " " .$Ad1 . ($Ad2 != ""? ", ". $Ad2:""));
            $CustomerName   = trim($UserTitle . " " . $UserFirstname . " " . $UserSurname);
            //$dpreq['amount'] = 0.03;
            $PaymentAmount  = (100 * $dpreq['amount']);// this is 1 pound (100p)
            $OrderDataRaw   = "Direct Payment";     // order description
            $OrderID        = trim($dpreq['transactionid']); // Order Id - needs to be unique

            //- integration user details - //
            $PW             = \Config::get('bpg.PASSWORD'); //"MyShaInPassPhrase" | skymerchant@2017!%* | skymerchant@2017;
            $PSPID          = \Config::get('bpg.SESSIONID'); //"MyPSPID" | epdq6023566 | epdqtest6023566 | ;

            //- payment design options - //
            $TXTCOLOR       =   "#005588";
            $TBLTXTCOLOR    =   "#005588";
            $FONTTYPE       =   "Helvetica, Arial";
            $BUTTONTXTCOLOR =   "#005588";
            $BGCOLOR        =   "#d1ecf3";
            $TBLBGCOLOR     =   "#ffffff";
            $BUTTONBGCOLOR  =   "#cccccc";
            $TITLE          =   "Skybourne - Secure Payment Page";
            $LOGO           =   \Config::get('bpg.LOGOURL');
            $PMLISTTYPE     =   1;

            //= create string to hash (digest) using values of options/details above
            $DigestivePlain =
            "AMOUNT=" . $PaymentAmount . $PW .
            "BGCOLOR=" . $BGCOLOR . $PW .
            "BUTTONBGCOLOR=" . $BUTTONBGCOLOR . $PW .
            "BUTTONTXTCOLOR=" . $BUTTONTXTCOLOR . $PW .
            "CN=" . $CustomerName  . $PW .
            "COM=" . $OrderDataRaw  . $PW .
            "CURRENCY=" . $CurrencyCode . $PW .
            "EMAIL=" . $ShopperEmail . $PW .
            "FONTTYPE=" . $FONTTYPE . $PW .
            "LANGUAGE=" . $ShopperLocale . $PW .
            "LOGO=" .$LOGO . $PW .
            "ORDERID=" . $OrderID . $PW .
            "OWNERADDRESS=" . $Addressline1n2 . $PW .
            "OWNERCTY=" . $BillCountry . $PW .
            "OWNERTELNO=" . $ContactTel . $PW .
            "OWNERTOWN=" . $BillTown . $PW .
            "OWNERZIP=" . $Pcde . $PW .
            "PMLISTTYPE=". $PMLISTTYPE . $PW .
            "PSPID=" . $PSPID . $PW .
            "TBLBGCOLOR=" . $TBLBGCOLOR . $PW .
            "TBLTXTCOLOR=" . $TBLTXTCOLOR . $PW .
            "TITLE=" . $TITLE . $PW .
            "TXTCOLOR=" . $TXTCOLOR . $PW .
            "";
            $DigestivePlain =
                "AMOUNT=" . $PaymentAmount . $PW .
                "CURRENCY=" . $CurrencyCode . $PW .
                "LANGUAGE=" . $ShopperLocale . $PW .
                "ORDERID=" . $OrderID . $PW .
                "PSPID=" . $PSPID . $PW .
                "";

            //=SHA encrypt the string=//
            $strHashedString_plain = strtoupper(sha1($DigestivePlain));
            //echo "DP: ".$DigestivePlain."<br/>";
            //echo "Hash: ".$strHashedString_plain."<br/>";

            return view('pages.makedirectpayment', [
                'reqip' => $reqip,
                'name' => "Make a payment",
                'currencySymbol' => $currencySymbol,
                'title' => $dpreq['title'],
                'firstname' => $dpreq['firstname'],
                'lastname' => $dpreq['lastname'],
                'email' => $dpreq['email'],
                'phone' => $dpreq['phone'],
                'address' => $dpreq['adrsline1'].", ".($dpreq['adrsline2'] !== "" ?$dpreq['adrsline2']." ":"")
                            .$dpreq['town'].", ".$dpreq['postcode'].", ".$dpreq['county']." ".$dpreq['country'],
                'description' => $dpreq['description'],
                'amount' => $dpreq['amount'],
                'reference' => $dpreq['reference'],
                'orderid' => $dpreq['transactionid'],

                "PaymentAmount" => $PaymentAmount,
                "CustomerName" => $CustomerName ,
                "OrderDataRaw" => $OrderDataRaw ,
                "CurrencyCode" => $CurrencyCode ,
                "ShopperEmail" => $ShopperEmail ,
                "FONTTYPE" => $FONTTYPE ,
                "ShopperLocale" => $ShopperLocale ,
                "LOGO" => $LOGO ,
                "OrderID" => $OrderID ,
                "Addressline1n2" => $Addressline1n2 ,
                "BillCountry" => $BillCountry ,
                "ContactTel" => $ContactTel ,
                "BillTown" => $BillTown ,
                "Pcde" => $Pcde ,
                "PMLISTTYPE" => $PMLISTTYPE ,
                "PSPID" => $PSPID ,
                "BGCOLOR" => $BGCOLOR ,
                "BUTTONBGCOLOR" => $BUTTONBGCOLOR ,
                "BUTTONTXTCOLOR" => $BUTTONTXTCOLOR ,
                "TBLBGCOLOR" => $TBLBGCOLOR ,
                "TBLTXTCOLOR" => $TBLTXTCOLOR ,
                "TITLE" => $TITLE ,
                "TXTCOLOR" => $TXTCOLOR ,

                'strHashedString_plain' => $strHashedString_plain,
            ]);

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Track card payments
     * @param Request $request
     * @param int $paymentid
     * @return int
     */
    private function trackonCardPayment($request, $paymentid)
    {
        DB::transaction(function () use ($request, &$paymentid) {
            $orderid = $request->has("orderID")?$request->orderID:"";
            // Check attempts
            //$attempts = Cardpayments::where("orderid", "=", $orderid)->count();
            $get = Cardpayments::where("orderid", "=", $orderid)->first();

            if ($get !== null) {
                $paymentid = $get->id;
                Cardpayments::where("orderid", "=", $orderid)
                    ->update(['attempts' => ($get->attempts+1)]);
            } else {
                $cpay = new Cardpayments;
                $cpay->orderid = $orderid;
                $cpay->currency = $request->has("currency")?$request->currency:"";
                $cpay->amount = $request->has("amount")?$request->amount:"";
                $cpay->paymethod = $request->has("PM")?$request->PM:"";
                $cpay->acceptance = $request->has("ACCEPTANCE")?$request->ACCEPTANCE:"";
                $cpay->statuscode = $request->has("STATUS")?$request->STATUS:"";
                $cpay->cardno = $request->has("CARDNO")?$request->CARDNO:"";
                $cpay->cexpd = $request->has("ED")?$request->ED:"";
                $cpay->cname = $request->has("CN")?$request->CN:"";
                $cpay->trxdate = $request->has("TRXDATE")?$request->TRXDATE:"";
                $cpay->payid = $request->has("PAYID")?$request->PAYID:"";
                $cpay->ncerror = $request->has("NCERROR")?$request->NCERROR:"";
                $cpay->brand = $request->has("BRAND")?$request->BRAND:"";
                $cpay->ipcty = $request->has("IPCTY")?$request->IPCTY:"";
                $cpay->cccty = $request->has("CCCTY")?$request->CCCTY:"";
                $cpay->eci = $request->has("ECI")?$request->ECI:"";
                $cpay->cvccheck = $request->has("CVCCheck")?$request->CVCCheck:"";
                $cpay->ip = $request->has("IP")?$request->IP:"";
                $cpay->attempts = 1;
                $cpay->save();
                $paymentid = $cpay->id;
            }
        });
        return $paymentid;
    }

    /**
     * Catch direct payment PG response
     * @param Request $request
     * @param string $response
     * @return Response
     */
    public function directPaymentResponse(Request $request, $response)
    {
        try {
            //echo "res:$response<br/>";

            //orderID=12215088833525402&currency=GBP&amount=471.47
            //&PM=CreditCard&ACCEPTANCE=test123
            //&STATUS=5
            //&CARDNO=XXXXXXXXXXXX4444
            //&ED=0818&CN=S+K+MUNASINGHE&TRXDATE=10%2F24%2F17
            //&PAYID=3026468722&PAYIDSUB=0&NCERROR=0&BRAND=MasterCard&IPCTY=GB&CCCTY=99
            //&ECI=7&CVCCheck=NO
            //&AAVCheck=NO&VC=NO&IP=82.31.135.239
            //&SHASIGN=3E84C8BD0854D0F104B1BA92234EAEA9CE7FCCCE
            $request->flash();
            $paymentid = 0;
            if (!$request->has("amount")) {
                return view('pages.paymentresponse', [
                        'name' => "Payment not successful",
                        'response' => "fail",
                        'message' => "Payment details missing!"
                    ]);
            }

            $paymentid = $this->trackonCardPayment($request, $paymentid);

            $transactionId = $request->has("orderID")?$request->orderID:($request->has("ORDERID")?$request->ORDERID:"");

            $id = Session::get('dpreqid');

            if ($id === null || !($id > 0)) {
                return redirect('/')->with('error', 'Your session has been expired! Please try to find a flight again.');
            }

            // Clear session value to stop refresh the page / Explicitly change url and trigger success email
            Session::forget('dpreqid');

            // Update payments table with flightbooking id--
            $dpreq = Paymentrequest::find($id);
            $cpayment = Cardpayments::find($paymentid);
            $cpayment->cardpayable_type = 'paymentrequests';
            $cpayment->cardpayable_id = $id;
            $cpayment->save();
            //echo "trn:".$transactionId."<br/>id:".$id." dbtrn:".$fbreq['transactionid'];

            if (!isset($dpreq['transactionid']) || $dpreq['transactionid'] != $transactionId) {
                $message = "Some issue was arose while processing your transaction. So, your payment has not been confirmed. "
                        . "Please contact Skybourne.";
                return view('pages.paymentresponse', [
                        'name' => "Payment not successful",
                        'response' => "fail",
                        'message' => $message
                    ]);
            }

            switch ($response) {
                case 'success':
                    $status = "PAYMENT_SUCCESS";
                    $pgresponse = 'success';
                    $message = "Your payment has been successfully proccessed.";
                    break;

                case 'decline':
                    $status = "PAYMENT_DECLINE";
                    $pgresponse = 'fail';
                    $message = "Your payment is declined. So, your order has not been confirmed.";
                    break;

                case 'exception':
                    $status = "PAYMENT_EXCEPTION";
                    $pgresponse = 'fail';
                    $message = "Some issue was arose while processing your transaction. Your payment transaction has not success. "
                            . "So, your order has not been confirmed.";
                    break;

                case 'canceled':
                    $status = "PAYMENT_CANCELED";
                    $pgresponse = 'fail';
                    $message = "You have cancelled the transaction while processing. So, your order has not been confirmed.";
                    break;
            }

            // Update DB
            $dpreq->status = $status;
            $dpreq->save();

            $mailresponse = $this->sendPaymentResponseMail($id, $pgresponse, $message);
            if ($pgresponse === 'success') {
                return view('pages.paymentresponse', [
                    'name' => "Payment confirmation",
                    'response' => $response,
                    'message' => "Your payment has been successfully proccessed. "
                    . "You will recieve the confirmation email to ".$mailresponse['sendtoemail']."! <br/>"
                    . "Your payment reference is: ".$dpreq->reference." "
                ]);
            } else {
                return view('pages.paymentresponse', [
                    'name' => "Payment not successful",
                    'response' => $response,
                    'message' => "Your payment not successful."
                    . "Your payment reference is: ".$dpreq->reference." ",
                    'error' => ["Your payment not successful!"]
                ]);
            }

        } catch (\Exception $ex) {
            return redirect('/')
                            ->withErrors('Sorry! Something went wrong!')
                            ->withInput();
        }
    }

    /**
     * Send direct payment successful message
     * @param int $paymentRequestId
     * @param string $pgresponse
     * @param string $message
     * @return response
     */
    private function sendPaymentResponseMail($paymentRequestId, $pgresponse, $message)
    {
        $dpreq = Paymentrequest::with('cardpayments')->find($paymentRequestId);
        $currencySymbol = $this->getCurrencySymbol("GBP");

            // Send mail
            $oMsgRepo = new MessagesRepository();

        if ($pgresponse === "success") {
            $statusstring = $message;
            $layout = "emails.directpaymentconfirmation";
            $subject = "Payment confirmation";
        } else {
            $statusstring = $message;
            $layout = "emails.paymentfail";
            $subject = "Payment Not Successful";
        }
            $sendtoemail = $dpreq->email;
            $sendtoname = trim($dpreq->firstname.($dpreq->lastname != ""?" ".$dpreq->lastname:''));
            $sendernameinbody = "Skybourne Travels";
            $senderemail = $oMsgRepo->_bookingsemail['email'];
            $sendername = $oMsgRepo->_bookingsemail['name'];
            $replyto = $oMsgRepo->_defReplyto;
            $cc = [[$oMsgRepo->_companycustomerqueriesemail['email'], $oMsgRepo->_companycustomerqueriesemail['name']]];
            $bcc = "";
            $attachmentFile = "";

            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'statusstring' => $statusstring,
                'paymentReference' => $dpreq->reference,
                'requestDetails'=>$dpreq->toArray(),
                'message' => $message,
                'currencySymbol' => $currencySymbol,
                'datetime' => date('y-m-d h:i:s') ];

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

    private function sendBookingDetailEmail($bookingData)
    {
        $oMsgRepo = new MessagesRepository();
            $string = "";
            $string .= "<br/>Name: ".$bookingData['name'];
            $string .= "<br/>Email: ".$bookingData['email'];
            $string .= "<br/>Gender: ".$bookingData['gender'];
            $string .= "<br/>Phone: ".$bookingData['phone'];
            $string .= "<br/>DOB: ".$bookingData['dob'];

            $flightDetails = "";
            if(isset($bookingData['flight'])){
                $currencySymbol = $this->getCurrencySymbol(isset($bookingData['flight']['currency'])?$bookingData['flight']['currency']:"");
                $flightDetails .= "<br/>Amount: ".$currencySymbol.$bookingData['flight']['price'];
                $flightDetails .= "<br/>Airline: ".$bookingData['flight']['ticketAirlineName'];
                $flightDetails .= "<br/>Class: ".$bookingData['flight']['cabinClass'];

                if(isset($bookingData['flight']['flightJournies']) && !empty($bookingData['flight']['flightJournies']))
                foreach($bookingData['flight']['flightJournies'] as $k=>$journey){
                    $flightDetails .= "<br/><br/><b>Journey ".($k+1)."</b>";
                    $flightDetails .= "<br/>Origin Airport: ".$journey['originAirport'];
                    $flightDetails .= "<br/>Departure Time: ".$journey['departureTime'];
                    $flightDetails .= "<br/>Destination Airport: ".$journey['destinationAirport'];
                    $flightDetails .= "<br/>Arrival Time: ".$journey['arrivalTime'];
                }
            }

            $string .= "<br/>Flight Details: ".$flightDetails;

            $layout = "emails.messages";
            $subject = "Booking Request";

            $sendernameinbody = "Skybourne Travels";
            $sendtoemail = $oMsgRepo->_bookingsemail['email'];
            $sendtoname = $oMsgRepo->_bookingsemail['name'];
            $senderemail = $bookingData['email'];
            $sendername = $bookingData['name'];
            $replyto = ['email' => $senderemail, 'name' => $sendername];
            $cc = ""; //[[$oMsgRepo->_companycustomerqueriesemail['email'], $oMsgRepo->_companycustomerqueriesemail['name']]];
            $bcc = "";
            $attachmentFile = "";
            //echo "<br/>E:";var_dump($bookingData);echo "<br/>";var_dump($senderemail);die();
            $data = ['subject' => $subject, 'sendtoname' => $sendtoname, 'sendernameinbody' => $sendernameinbody,
                'body' => $string,
                'user_name' => $bookingData['name'],
                'datetime' => date('y-m-d h:i:s') ];

            //echo "<pre>"; print_r($data); die();

            //sendmail($subject, $template, $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto = [], $cc = '', $bcc = '', $attachmentFile = array(),  $memoryvar = null)

            /*
            $mailresponse = $this->sendMessage(
                    $layout, $subject, $string, $sendtoname, $sendernameinbody,
                    $senderemail, $sendername, $sendtoemail, $data, $replyto, $cc, $bcc);
            //sendmail($layout, $subject, $body, $sendtoname, $sendernameinbody,
            //$senderemail, $sendername, $sendtoemail, $dataArray = [],
            //$replyto = [], $cc = '', $bcc = '', $attachmentFile = '',  $memoryvar = null)
            */

            $mailresponse = $oMsgRepo->sendmail(
                $subject,
                $layout,
                $data,
                $sendtoemail,
                $sendtoname,
                $senderemail,
                $sendername/*,
                $replyto,
                $cc,
                $bcc*/
            );
            //sendmail($subject, $template, $data, $sendtoemail, $sendtoname, $senderemail, $sendername,
            //$replyto = [], $cc = '', $bcc = '', $attachmentFile = array(),  $memoryvar = null)

            $mailresponse['sendtoemail'] = $sendtoemail;
            return $mailresponse;
    }

    /**
     * Call back request from master Layout
     * @return vew
     */
    public function callBackRequest(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [ 'phone' => 'required|min:10|max:15' ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('/')
                            ->withErrors($validator->errors())
                            ->withInput();
            }

            $repoMessage = new MessagesRepository();
            $telephone = ($request->phone?$request->phone:"");

            $layout = 'emails.callback';
            $subject = "Skybourne - Callback Request";
            $from = \Config::get('mail.from');
            $senderemail = $from['address'];
            $sendername = $from['name'];
            $sendernameinbody = "";
            $replyto = $aCC = $aBCC = [];
            $attachmentFile = "";
            $sendtoemail = $repoMessage->_companycustomerqueriesemail["email"];
            $sendtoname = $repoMessage->_companycustomerqueriesemail["name"];
            $data['data'] = ['telephone'=>$telephone];

            $response = $repoMessage->sendmail($subject, $layout,   $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto, $aCC, $aBCC, $attachmentFile);

            if (isset($response[0]) && ($response[0] == true)) {
                return redirect('/')
                            ->with('success', "Your message has been sent to Skybourne Travels.")
                            ->withInput();
            } else {
                return redirect('/')
                            ->withErrors("Something went wrong! Your call back request has not been sent to Skybourne Travels.")
                            ->withInput();
            }
        }
        return redirect('/');
    }

    /**
     * Newslatter sign up request email sending to office
     * @param Request $request
     * @return type
     */
    public function signupNewlatters(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [ 'email' => 'required|email' ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('/')
                            ->withErrors($validator->errors())
                            ->withInput();
            }

            $repoMessage = new MessagesRepository();
            $email = ($request->email?$request->email:"");

            $layout = 'emails.signupnl';
            $subject = "Skybourne - Newslatter signup Request";
            $from = \Config::get('mail.from');
            $senderemail = $from['address'];
            $sendername = $from['name'];
            $sendernameinbody = "";
            $replyto = $aCC = $aBCC = [];
            $attachmentFile = "";
            $sendtoemail = $repoMessage->_companycustomerqueriesemail["email"];
            $sendtoname = $repoMessage->_companycustomerqueriesemail["name"];
            $data['data'] = ['email'=>$email];

            $response = $repoMessage->sendmail($subject, $layout,   $data, $sendtoemail, $sendtoname, $senderemail, $sendername, $replyto, $aCC, $aBCC, $attachmentFile);

            if (isset($response[0]) && ($response[0] == true)) {
                return redirect('/')
                            ->with('success', "Your message has been sent to Skybourne Travels.")
                            ->withInput();
            } else {
                return redirect('/')
                            ->withErrors("Something went wrong! Your newslatter sign-up request has not been sent to Skybourne Travels.")
                            ->withInput();
            }
        }
        return redirect('/');
    }

}
