<?php if(isset($passengersDetails) && !empty($passengersDetails)){ ?>
<div class="col-md-12 summarytour gutter_top_10px">
    <div class="panel panel-body summarytour bg_bluesw">
        <h2 class="txt_white titleItinerar">Passengers Details</h2>
            @foreach($passengersDetails as $k=>$personData)
            <div class="row">
                <div class="col-lg-12"><strong>Passenger #{{($k+1)}}</strong></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>Title</b>:</div><div class="col-lg-8"><span>{{$personData['title']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>First name</b>:</div><div class="col-lg-8"><span>{{$personData['firstname']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>Last Name</b>:</div><div class="col-lg-8"><span>{{$personData['lastname']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>email</b>:</div><div class="col-lg-8"><span>{{$personData['email']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>gender</b>:</div><div class="col-lg-8"><span>{{$personData['gender']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>phone</b>:</div><div class="col-lg-8"><span>{{$personData['phone']}}</span></div></div>
                <div class="col-lg-12"><div class="col-lg-4"><b>Date of birth</b>:</div><div class="col-lg-8"><span>{{$personData['dob']}}</span></div></div>
            @if($personData['passportno'] !== "")
                <h3>Passport Details</h3>
                    <div class="col-lg-12"><div class="col-lg-4"><b>Passport No</b>:</div><div class="col-lg-8"><span>{{$personData['passportno']}}</span></div></div>
                    <div class="col-lg-12"><div class="col-lg-4"><b>Issued Country</b>:</div><div class="col-lg-8"><span>{{$personData['issuecountry']}}</span></div></div>
                    <div class="col-lg-12"><div class="col-lg-4"><b>Expire date</b>:</div><div class="col-lg-8"><span>{{$personData['expiredate']}}</span></div></div>
                    <div class="col-lg-12"><div class="col-lg-4"><b>Nationality</b>:</div><div class="col-lg-8"><span>{{$personData['nationality']}}</span></div></div>
            @endif
            </div>
            @endforeach
    </div>
    
</div>
<?php } 