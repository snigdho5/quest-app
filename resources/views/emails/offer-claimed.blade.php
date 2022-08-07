@component('mail::message')

<p style="font-weight: normal">Hey {{$data->user->name}},</p>
<p style="font-weight: normal">Congratulations on completing a threshold on the Walk n Win feature of the Quest app. Your voucher code is {{$data->code}}.</p>
<p style="font-weight: normal">To redeem the voucher all you need to do to is head to the {{$data->store->name}} store at Quest and collect it within {{ $data->redeem_within}} days!</p>
<p style="font-weight: normal">Here’s hoping you that you win many more such vouchers. Just keep following the Quest pages on social media and be on an active lookout on the Quest app.</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
