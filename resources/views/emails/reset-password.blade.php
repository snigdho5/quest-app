@component('mail::message')

<h1 style="text-align: center; font-weight: normal">Hi {{$data->name}}, looks like you lost your password?</p>
<h4 style="text-align: center">Enter this following OTP in your app to change your password.</h4>

<h1 style="text-align: center">{{$data->fhash}}</h1>

<p style="text-align: center"><small>You receive this email because you or someone initiated a password reset operation on your Quest Mall account. If you didn’t ask to recover your password, please ignore this email.</small></p>

@endcomponent
