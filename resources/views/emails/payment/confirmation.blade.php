@component('mail::message')
# Thank {{ $user->name }},

Your payment for {{ $total }} was sucessful. The funds will be withdrawn from your account in 1-3 business days. If you have any questions, please let us know.

Thank you!<br>

The SenRent Team<br>
support@senrent.com

@endcomponent
