<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
        
    public $_limit = 10;
    //use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    
    public function index()
    {
        return view('backend.dashboard', [
            'name' => "Welcome Backend",
        ]);
    }
}
