@component('mail::message')
<p>Hi {{$data['name']}},</p>

<p>Thank you for registering with us. Please verify your email id to access your account.</p>

<p>You OTP is: {{$data['otp']}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
