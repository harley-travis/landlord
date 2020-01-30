@component('mail::message')
# Dear {{ $user->name }},

Unfortunately, your payment for rent was unsuccessful in the amount of ${{ number_format( $total / 100,2 ) }}. 

Please add funds to your account, as soon as possible to avoid any late fees. 

If you are finding that this is an error, please contact our support team at support@senrent.com. Be sure to inform your landlord as well.

If you have any questions, please let us know.

Thank you,<br>

The SenRent Team<br>
support@senrent.com

@endcomponent
