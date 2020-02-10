@component('mail::message')
# Thank you {{ $user->name }} for your payment,
 
Your landlord has recorded your payment in the amount of ${{ number_format( $total ) }} on {{ $date }}. The funds will be withdrawn from your account in 1-3 business days. Your confirmation number is {{ $confirmationNumber }}.

If you have any questions, please let us know.

Thank you!<br>

The SenRent Team<br>
support@senrent.com

@endcomponent
