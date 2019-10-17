@component('mail::message')
# Greetings {{ $user->name }},
Your rent is coming due. 

Total amount due: <span style="color:red">${{ $property->rent_amount }}</span>

@component('mail::button', ['url' => 'http://senrent.com'])
Pay Now
@endcomponent

@endcomponent
