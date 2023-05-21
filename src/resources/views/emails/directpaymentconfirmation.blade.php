<!-- resources/views/emails/directpaymentconfirmation.blade.php -->

<h1>{!! $subject !!}</h1>

Hi {!! $sendtoname !!},

<p>{{$statusstring}}</p>

Your payment reference is: <strong>{{$paymentReference}}</strong>

<h3>Billing Details</h3>
        
<p><b>Title</b>:<span>{{$requestDetails['title']}}</span></p>
<p><b>First name</b>:<span>{{$requestDetails['firstname']}}</span></p>
<p><b>Last Name</b>:<span>{{$requestDetails['lastname']}}</span></p>
<p><b>email</b>:<span>{{$requestDetails['email']}}</span></p>
<p><b>phone</b>:<span>{{$requestDetails['phone']}}</span></p>
<p><b>Address Line 1</b>:<span>{{$requestDetails['adrsline1']}}</span></p>
<p><b>Address Line 2</b>:<span>{{$requestDetails['adrsline2']}}</span></p>
<p><b>Town</b>:<span>{{$requestDetails['town']}}</span></p>
<p><b>Postcode</b>:<span>{{$requestDetails['postcode']}}</span></p>
<p><b>County</b>:<span>{{$requestDetails['county']}}</span></p>
<p><b>Country</b>:<span>{{$requestDetails['country']}}</span></p>
<br/>
<p><b>Description</b>:<span>{{$requestDetails['description']}}</span></p>

<h3>Transaction Details</h3>
<p><b>Amount &pound;</b>:<span>{{$requestDetails['amount']}}</span></p>
<p><b>Invoice/Reference</b>:<span>{{$requestDetails['reference']}}</span></p>
<br/>
<br/>

<p>Thank you!</p>
<p>{{$sendernameinbody}}</p>
<p>{!! $datetime !!}</p>