<?php 
if(isset($paymentDetails) && !empty($paymentDetails)){ ?>
<div class="col-md-12 summarytour gutter_top_10px">
    <div class="panel panel-body summarytour bg_bluesw">
        <h2 class="txt_white titleItinerar">Card Payment Details</h2>
        @foreach($paymentDetails as $cpayment )
        <ul class="">
            <li  class="">
                <div class="content fare">
                    
                    <div class="form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Order ID</label>
                        <div class="col-md-6">{{ $cpayment['orderid'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Currency</label>
                        <div class="col-md-6">{{ $cpayment['currency'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Amount</label>
                        <div class="col-md-6">{{ $cpayment['amount'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Pay Method</label>
                        <div class="col-md-6">{{ $cpayment['paymethod'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">PG Status Code</label>
                        <div class="col-md-6">{{ $cpayment['statuscode'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">Card No</label>
                        <div class="col-md-6">{{ $cpayment['cardno'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">PG Pay ID</label>
                        <div class="col-md-6">{{ $cpayment['payid'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">PG Date</label>
                        <div class="col-md-6">{{ $cpayment['trxdate'] }}</div>
                    </div>
                    
                    <div class=" form-group col-lg-12">
                        <label for="name" class="col-md-4 control-label">System Time:</label>
                        <div class="col-md-6">{{ $cpayment['created_at'] }}</div>
                    </div>
                                        
                </div>
            </li>
        </ul>
        @endforeach
    </div>
</div>
<?php }