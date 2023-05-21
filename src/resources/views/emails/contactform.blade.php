<!-- resources/views/emails/messages.blade.php -->

<h1>{!! $subject !!}</h1>

Hi Skybourne Travel,
<p></p>
<br/>
Customer has contacted you through Skybournetravels.co.uk "Contact us" form.
<br/>
<p><b>Name:</b> {!! $data['name'] !!}</p>
<p><b>Telephone:</b> {!! $data['telephone'] !!}</p>
<p><b>Email:</b> {!! $data['email'] !!}</p>
<p><b>Address:</b> {!! $data['address'] !!}</p>
<br/>
<p><b>Message:</b> {!! $data['message'] !!}</p>

<p>{!! $datetime !!}</p>
