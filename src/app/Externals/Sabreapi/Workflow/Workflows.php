<?php
namespace App\Externals\Sabreapi\Workflow;

use App\Externals\Sabreapi\Workflow\SharedContext;

class Workflows {
    //put your code here
    private $sharedContext;
    private $startActivity;
    
    public function __construct(&$startActivity) {
        $this->startActivity = $startActivity;
    }
    
    public function runWorkflow() {
        $this->sharedContext = new SharedContext();
        $next = $this->startActivity;
        while($next) {
            $next = $next->run($this->sharedContext);
        }
        return $this->sharedContext;
    }
}
