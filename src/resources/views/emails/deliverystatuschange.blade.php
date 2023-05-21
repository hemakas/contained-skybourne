<!-- resources/views/emails/messages.blade.php -->

<h1>Your delivery status changed</h1>

Hi {{ $sendtoname }},
<p>Your parcel delivery changed to {{ $status }}</p>
<br/>
You can track your parcel. Your tracking number: {{ $tracking_no }}
<br/>
Thank you!
{{ $sendernameinbody }}
<br/>
<p>Message from SenuShipping</p>
<p>{{ $datetime }}</p>
