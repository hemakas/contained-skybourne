<!-- resources/views/emails/messages.blade.php -->

<h1>{!! $subject !!}</h1>

Hi Skybourne Travel,
<p></p>
<br/>
You have received a newsletter signup request from website.
<br/>
<p><b>Email:</b> {!! $data['email'] !!}</p>

<p>{!! $datetime !!}</p>
