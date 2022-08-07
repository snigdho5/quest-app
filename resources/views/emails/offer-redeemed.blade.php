@component('mail::message')

<p style="font-weight: normal">Hi {{$data->user->name}},</p>
<p style="font-weight: normal">Congratulations on redeeming your Walk n Win voucher at {{$data->store->name}} store at Quest, successfully!</p>
<p style="font-weight: normal">To win more such exciting offers keep using the Walk N Win feature on the Quest app, whenever you visit Quest.</p>
<p style="font-weight: normal">We look forward to you walking and winning more!</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
