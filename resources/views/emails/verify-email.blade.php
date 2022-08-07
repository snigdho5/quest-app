@component('mail::message')
<p>Hi {{$data['name']}},</p>

<p>Thank you for registering with us. Please verify your email id to access your account.</p>

@component('mail::button', ['url' => url('verifyEmail/'.$data['chash'])])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
