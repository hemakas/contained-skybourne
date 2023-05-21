<!-- resources/views/emails/messages.blade.php -->

<h1>Your itinerary</h1>

Hi {{ $sendtoname }},
<p>This is your itinerary details.</p>
<br/>
Email content goes here....
<br/>
<p>Go to payment</p>
Thank you!
{{ $sendernameinbody }}
<br/>
<p>Message from Skywings</p>
<p>{{ $datetime }}</p>
