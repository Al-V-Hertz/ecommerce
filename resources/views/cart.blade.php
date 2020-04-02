@extends('layouts.app')
@section('content')
<div class="container">
    {{-- TRIGGER --}}
    <button class="btn btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#checkout">Proceed to Checkout</button>

    {{-- MODAL --}}
    <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Check Out</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table style="width: 100%">
                <thead>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </thead>
                @foreach(Session::get('orders') as $order)
                    <tr>
                        <td>{{$order['items']['item_name']}}</td>
                        <td>{{$order['qty']}}</td>
                        <td>{{$order['items']['item_price']}}</td>
                        <td>{{$order['qty']*$order['items']['item_price']}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><h1>Grand Total:</h1></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="atc" type="submit" form="order" class="btn btn-primary">Checkout Order</button>
            </div>
          </div>
        </div>
    </div>
    
    {{-- TABLE --}}

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