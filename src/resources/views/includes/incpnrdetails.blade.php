<?php 
if(isset($pnrDetails['pnr']) && isset($pnrDetails['pnrstatus']) && 
        isset($pnrDetails['airlineresponse']) && isset($pnrDetails['pnrtimestamp'])){ ?>
<div class="col-md-12 summarytour gutter_top_10px">
    <div class="panel panel-body summarytour bg_bluesw">
        <h2 class="txt_white titleItinerar">PNR Response</h2>
        <ul class="">
            <li  class="">
                <div class="content fare">
                    
                    <div class="form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Itinerarys Reference ID</label>
                        <div class="col-md-6">{{ $pnrDetails['pnr'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Status</label>
                        <div class="col-md-6">{{ $pnrDetails['pnrstatus'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Airline Responses</label>
                        <div class="col-md-6">{{ $pnrDetails['airlineresponse'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">PNR Timestamp</label>
                        <div class="col-md-6">{{ $pnrDetails['pnrtimestamp'] }}</div>
                    </div>
                                        
                </div>
            </li>
        </ul>
    </div>
</div>
<?php }