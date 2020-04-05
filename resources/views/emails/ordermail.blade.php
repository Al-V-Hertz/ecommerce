@component('mail::message')
# Hi Customer {{$username}}, 

These are your orders:
@component('mail::table')
| Ordered Item  | Quantity      | Amount Due|
| ------------- |:-------------:| ---------:|
@foreach()
| ------------- |:-------------:| ---------:|
@endforeach
    {{-- | Col 2 is      | Centered      |       |
    | Col 3 is      | Right-Aligned |       | --}}
@endcomponent

We Have Received Your Order. Our man is on the move

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

At Your Service,<br>
{{ config('app.name') }}
@endcomponent
