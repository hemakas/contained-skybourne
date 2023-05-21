<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Controllers\Backend\DashboardTrait;

class BackendComposer 
{

    use DashboardTrait;
    
    public function compose(View $view)
    {
        $newmsgs = $this->dashboardNewMessages();
        $view->with('newmessages', $newmsgs);
        $alert = $this->dashboardAlerts();
        $view->with('alerts', $alert);
        $ausername = $this->getUsername();
        $view->with('ausername', $ausername);
        $ausertype = $this->getUserType();
        $view->with('ausertype', $ausertype);        
    }

}
