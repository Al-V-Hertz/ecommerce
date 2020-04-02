@extends('layouts.app')
@section('content')
<div class="container">
    <button class="btn btn-primary" style="margin-bottom: 10px;">Proceed to Checkout</button>
    <div class="jumbotron">
        <h1>My Cart</h1>
    </div>
   <table id="ordertable">
       <thead>
           <th></th>
           <th>Ordered Item</th>
           <th>Quantity</th>
           <th>Price</th>
           <th>Subtotal</th>
       </thead>
       <tbody>
        @foreach(Session::get('orders') as $order)
            <tr>
                <td><img id="orderimg" src={{$order['items']['item_image']}}></td>
                <td>{{$order['items']['item_name']}}</td>
                <td>{{$order['qty']}}</td>
                <td>{{$order['items']['item_price']}}</td>
                <td>{{$order['qty']*$order['items']['item_price']}}</td>
            </tr>
        </div>
    @endforeach
       </tbody>
   </table>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#ordertable').DataTable();
        });
    </script>
@endsection