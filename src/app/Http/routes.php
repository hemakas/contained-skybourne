<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

/**
 * User Login
 **/
Route::group(['middleware' => ['web']], function () {

        Route::get('/login', [ 'as' => '/login', 'uses' => 'Auth\AuthController@showLoginForm']);
        //Route::get('/login','Auth\AuthController@showLoginForm');
        Route::post('/login', [ 'as' => '/login', 'uses' => 'Auth\AuthController@login']); //userlogin
        //Route::post('/login','Auth\AuthController@login');
        Route::get('/logout', [ 'as' => '/logout', 'uses' => 'Auth\AuthController@logout']);
        //Route::get('/logout','Auth\AuthController@logout');

        // Registration Routes...
        Route::get('/register', 'Auth\AuthController@showRegistrationForm');
        Route::post('/register', 'Auth\AuthController@register');


		/**
		 * Testing
		 */
		Route::get('/testapi', 'ApitestController@testapi');
		Route::get('/testaction', 'PagesController@testaction');

});


Route::group(['prefix' => 'ajax'], function()
{
    Route::post('/cityairports', 'AjaxController@ajaxCityAirports');
});

/**
 * Front pages
 */
Route::get('/', 'PagesController@index');
Route::get('/holidays/offers', 'PagesController@holidayoffers');
Route::get('/holidays/{countryname}', 'PagesController@holidays');
Route::post('/holidays/{countryname}', 'PagesController@holidays');
Route::post('/holidays', 'PagesController@holidays');

Route::get('/holidays', 'PagesController@holidays');
Route::get('/itinerary/{itineraryurl}', 'PagesController@itinerary');
Route::post('/itinerary/{itineraryurl}', 'PagesController@itinerary');
Route::get('/hotels/{countryname}', 'PagesController@hotels');
Route::get('/hotel/{hotelurl}', 'PagesController@hotel');
Route::get('/customersupport', 'PagesController@customersupport');
Route::post('/customersupport', 'PagesController@customersupport');

Route::post('/callback', 'PagesController@callBackRequest');
Route::post('/signupnl', 'PagesController@signupNewlatters');
Route::get('/about-us', 'PagesController@aboutus');
Route::get('/holiday-types', 'PagesController@holidaytypes');
Route::get('/privacypolicy', 'PagesController@privacypolicy');
Route::get('/termsconditions', 'PagesController@termsconditions');
Route::get('/contact-us', 'PagesController@contact');
Route::get('/viewoffer', 'PagesController@viewoffer');
Route::get('/viewtour', 'PagesController@viewtour');
Route::post('/searchresults', 'PagesController@searchresults');
Route::post('/flightresults', 'PagesController@flightresults');
Route::post('/selectedflight', 'PagesController@flightJourniesConfirm');
Route::post('/booking/personal', 'PagesController@bookingPerson');
Route::get('/booking/payment', 'PagesController@makePayment');
Route::post('/booking/payment', 'PagesController@makePayment');
Route::post('/booking/confirm', 'PagesController@bookingConfirm');
Route::get('/payment/pgresponse', 'PagesController@pgResponse');
// Barclays response : success | decline | exception | canceled
Route::get('/payment/response/{response}', 'PagesController@paymentResponse');
//Route::get('/payment/response', 'PagesController@paymentResponse');

Route::get('/success', [ 'as' => '/success', 'uses' => 'PagesController@success']);
Route::get('/error', [ 'as' => '/error', 'uses' => 'PagesController@error']);
Route::get('/error/{errorcode}', [ 'as' => '/error/{errorcode}', 'uses' => 'PagesController@error']);

/**
 * Direct payment
 */
Route::get('/payment/direct/{token}', 'PagesController@directPayment');


Route::get('upload/images/facilities/{image}', function($image = null)
{
    $path = storage_path().'/app/public/facilities/' . $image;
    if (file_exists($path)) {
        return Response::download($path);
    }
});

Route::get('upload/images/hotels/{directory}/{image}', function($directory = '', $image = null)
{
    $path = storage_path()."/app/public/hotels/{$directory}/{$image}";
    if (file_exists($path)) {
        return Response::download($path);
    }
});

Route::get('upload/images/itineraries/{directory}/{image}', function($directory = '', $image = null)
{
    $path = storage_path()."/app/public/itineraries/{$directory}/{$image}";
    if (file_exists($path)) {
        return Response::download($path);
    }
});

Route::get('upload/images/carousels/{directory}/{image}', function($directory = '', $image = null)
{
    $path = storage_path()."/app/public/carousels/{$directory}/{$image}";
    if (file_exists($path)) {
        return Response::download($path);
    }
});

/**
 * Admin Panel
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'before' => 'admin'], function()
{
    Route::get('/login','Auth\AuthController@showLoginForm');
    Route::post('/login','Auth\AuthController@login');
    Route::get('/logout','Auth\AuthController@logout');

    // Registration Routes...
    Route::get('/register', 'AdminuserController@showRegistrationForm');
    Route::post('/register', 'AdminuserController@register');
    Route::get('/profile', 'AdminuserController@showProfile');
    Route::post('/profile', 'AdminuserController@editProfile');
    Route::patch('/profile', 'AdminuserController@editProfile');

    Route::get('/','DashboardController@index');

    Route::group(['prefix' => 'clients'], function()
    {
        Route::get('/', 'ClientController@index');
        Route::post('/', 'ClientController@store');
        Route::get('/{clientid}', 'ClientController@show');
        Route::post('/{clientid}', 'ClientController@update');
        Route::patch('/{clientid}/activate', 'ClientController@activate');
        Route::patch('/{clientid}', 'ClientController@update');
        Route::delete('/{clientid}', 'ClientController@destroy');
    });

    Route::group(['prefix' => 'facilities'], function()
    {
        Route::patch('/{facilityid}/activate', 'FacilityController@activate');
        Route::get('/{facilityid}', 'FacilityController@show');
        Route::post('/{facilityid}', 'FacilityController@update');
        Route::patch('/{facilityid}', 'FacilityController@update');
        Route::delete('/{facilityid}', 'FacilityController@destroy');
        Route::get('/', 'FacilityController@index');
        Route::post('/', 'FacilityController@store');
    });

    Route::group(['prefix' => 'countries'], function()
    {
        Route::patch('/{countryid}/activate', 'CountryController@activate');
        Route::get('/{countryid}', 'CountryController@show');
        Route::post('/{countryid}', 'CountryController@update');
        Route::patch('/{countryid}', 'CountryController@update');
        Route::delete('/{countryid}', 'CountryController@destroy');
        Route::get('/', 'CountryController@index');
        Route::post('/', 'CountryController@store');
    });

    Route::group(['prefix' => 'testimonials'], function()
    {
        Route::patch('/{testimonialid}/activate', 'TestimonialController@activate');
        Route::get('/{testimonialid}', 'TestimonialController@show');
        Route::post('/{testimonialid}', 'TestimonialController@update');
        Route::patch('/{countryid}', 'TestimonialController@update');
        Route::delete('/{countryid}', 'TestimonialController@destroy');
        Route::get('/', 'TestimonialController@index');
        Route::post('/', 'TestimonialController@store');
    });

    Route::group(['prefix' => 'hotels'], function()
    {
        Route::patch('/{hotelid}/activate', 'HotelController@activate');
        Route::get('/{hotelid}/update', 'HotelController@update');
        Route::get('/{hotelid}/images', 'HotelController@images');
        Route::patch('/{hotelid}/images', 'HotelController@images');
        Route::get('/{hotelid}', 'HotelController@show');
        Route::post('/{hotelid}', 'HotelController@store');
        Route::patch('/{hotelid}', 'HotelController@update');
        Route::delete('/{hotelid}', 'HotelController@destroy');
        Route::get('/', 'HotelController@index');
        Route::post('/', 'HotelController@store');
    });

    Route::group(['prefix' => 'itineraries'], function()
    {
        Route::get('/create', 'ItineraryController@store');
        Route::patch('/{itineraryid}/activate', 'ItineraryController@activate');
        Route::get('/{itineraryid}/update', 'ItineraryController@update');

        Route::post('/{itineraryid}/days', 'ItineraryController@storeday');
        Route::delete('/{itineraryid}/days/{dayid}', 'ItineraryController@deleteday');
        Route::patch('/{itineraryid}/days/{dayid}/update', 'ItineraryController@updateday');

        Route::get('/{itineraryid}/images', 'ItineraryController@images');
        Route::patch('/{itineraryid}/images', 'ItineraryController@images');
        Route::get('/{itineraryid}', 'ItineraryController@show');
        Route::patch('/{itineraryid}', 'ItineraryController@update');
        Route::delete('/{itineraryid}', 'ItineraryController@destroy');
        Route::get('/', 'ItineraryController@index');
        Route::post('/', 'ItineraryController@store');
    });

    Route::group(['prefix' => 'messages'], function()
    {
        Route::get('/compose', 'MessageController@composeMessage');
        Route::post('/compose', 'MessageController@composeMessage');
        Route::patch('/compose', 'MessageController@composeMessage');
        Route::get('/labels', 'MessageController@getLabels');
        Route::get('/', 'MessageController@index');

        Route::post('/', 'MessageController@sendMessage');
        Route::post('/save', 'MessageController@saveDraft');
        Route::post('/sendproperty', 'MessageController@sendPropertyToFirend');
        Route::get('/{messagebox}', 'MessageController@index');
        Route::get('/{messagebox}/labels/{labelname}', 'MessageController@getLabeledMessages');
        Route::post('/{messagebox}/{messageid}/labels', 'MessageController@setLabel');
        Route::delete('/{messagebox}/{messageid}/labels', 'MessageController@removeLabel');
        Route::patch('/{messagebox}/{messageid}/asread', 'MessageController@setMarkAsRead');
        Route::patch('/{messagebox}/{messageid}/asunread', 'MessageController@setMarkAsUnread');
        Route::get('/{messagebox}/{messageid}', 'MessageController@show');
        Route::delete('/{messagebox}/{messageid}', 'MessageController@destroy');
    });



    Route::group(['prefix' => 'pages'], function()
    {
        Route::get('/', 'PagesController@pages');
        Route::post('/', 'PagesController@store');
        Route::get('/{pageid}', 'PagesController@show');
        Route::patch('/{pageid}', 'PagesController@update');
        Route::patch('/{pageid}/activate', 'PagesController@activate');
    });


    Route::group(['prefix' => 'menus'], function()
    {
        Route::get('/mm', 'MenusController@getMainmenu');
        Route::get('/', 'MenusController@index');
        Route::post('/', 'MenusController@store');
        Route::get('/{menuid}', 'MenusController@show');
        Route::patch('/{menuid}', 'MenusController@update');
        Route::patch('/{menuid}/activate', 'MenusController@activate');
    });

    Route::group(['prefix' => 'carousels'], function()
    {
        Route::patch('/{carouselid}/activate', 'CarouselController@activate');
        Route::get('/{carouselid}/images/update', 'CarouselController@update');
        Route::patch('/{carouselid}/images', 'CarouselController@update');

        Route::get('/{carouselid}', 'CarouselController@show');
        Route::get('/', 'CarouselController@index');
        Route::post('/', 'CarouselController@store');
    });

    Route::group(['prefix' => 'payments'], function()
    {
        Route::get('/', 'PaymentsController@index');
        Route::get('/new', 'PaymentsController@store');
        Route::post('/new', 'PaymentsController@store');
        Route::get('/get/{id}', 'PaymentsController@show');
        Route::get('/cron', 'PaymentsController@cronExpiredRequests');

    });

    Route::group(['prefix' => 'flights'], function()
    {
        Route::get('bookings', 'FlightbookingsController@index');
    });

    Route::group(['prefix' => 'requests'], function()
    {
        Route::get('/', 'ItirequestsController@index');
        Route::get('/{itirequestsid}', 'ItirequestsController@show');
    });
});
