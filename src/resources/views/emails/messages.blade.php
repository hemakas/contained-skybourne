<!-- resources/views/emails/messages.blade.php -->

<h1>{!! $subject !!}</h1>

Hi {!! $sendtoname !!},
<p></p>
<br/>
{!! $body !!}
<br/>
{!! $user_name !!}
<br/>
<p>This email send through user messages.</p>
<p>{!! $datetime !!}</p>