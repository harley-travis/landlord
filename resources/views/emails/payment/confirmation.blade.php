@component('mail::message')
# Thank you {{ $user->name }} for your payment,

Your payment for ${{ number_format( $total ) }} was sucessful. The funds will be withdrawn from your account in 1-3 business days. If you paid by cash or check, then no other action is needed.

If you have any questions, please let us know.

Thank you!<br>

The SenRent Team<br>
support@senrent.com

@endcomponent
