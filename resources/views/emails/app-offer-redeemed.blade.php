@component('mail::message')

<p style="font-weight: normal">Hi {{$data->user->name}},</p>
<p style="font-weight: normal">Congratulations on redeeming an app only offer at {{$data->store->name}} at Quest, successfully!</p>
<p style="font-weight: normal">The offer you redeemed is <strong>"{{$data->offer_title}}"</strong></p>
<p style="font-weight: normal">The coupon code you used to redeem this offer is <strong>{{$data->code}}</strong></p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
