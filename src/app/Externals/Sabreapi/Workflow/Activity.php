<?php
namespace App\Externals\Sabreapi\Workflow;

interface Activity {

    function run(&$sharedContext);
}
