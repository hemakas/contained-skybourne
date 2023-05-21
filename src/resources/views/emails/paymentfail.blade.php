<!-- resources/views/emails/flightbooking.blade.php -->

<h1>{!! $subject !!}</h1>

Hi {!! $sendtoname !!},

<span style="color:red;">{{$statusstring}}</span>. 
<br/> 
Your payment reference is: <strong>{{$paymentReference}}</strong>
<br/>
<br/>
<p>{{$sendernameinbody}}</p>
<p>{!! $datetime !!}</p>