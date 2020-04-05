@component('mail::message')
#Hi Customer {{$username}}, 


These are your orders:
@component('mail::table')
| Ordered Item  | Quantity      | Amount Due| 
| ------------- |:-------------:| ---------:|
@foreach($orders as $order)
| {{$order['items']->item_name}}|{{$order['qty']}}| {{$order['subtotal']}} |
@endforeach
| Grand Total   |               |{{$total}} | 
@endcomponent

We Have Received Your Order. Our man is on the move

At Your Service,<br>
##{{ config('app.name') }}
@endcomponent
