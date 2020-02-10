@component('mail::message')
# Thank you {{ $user->name }} for your payment,

Your payment for ${{ number_format( $total / 100 ) }} was sucessfully process on {{ $date }}. The funds will be withdrawn from your account in 1-3 business days. Your confirmation number is {{ $confirmationNumber }}

If you have any questions, please let us know.

Thank you!<br>

The SenRent Team<br>
support@senrent.com

@endcomponent
