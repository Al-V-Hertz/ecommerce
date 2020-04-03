@extends('layouts.app')
@section('content')
<div class="container">
    {{-- CHECKOUT TRIGGER --}}
    <button class="btn btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#checkout">Proceed to Checkout</button>

    {{-- CHECKOUT MODAL --}}
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
                @if(Session::has('orders'))
                @foreach(Session::get('orders') as $order)
                    <tr>
                        <td>{{$order['items']['item_name']}}</td>
                        <td>{{$order['qty']}}</td>
                        <td>{{$order['items']['item_price']}}</td>
                        <td>{{$order['qty']*$order['items']['item_price']}}</td>
                    </tr>
                @endforeach
                @endif
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
    
    {{-- CONFIRM DELETE MODAL --}}
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deletemodal">Delete Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <h4>
             Are you sure you want to delete this order?
           </h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id ='confidel' type="button" class="btn btn-danger">DELETE!!!</button>
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
        <th></th>
      </thead>
      <tbody>
        @if(Session::has('orders'))
         @foreach(Session::get('orders') as $order)
             <tr>
                 <td><img id="orderimg" src={{$order['items']['item_image']}}></td>
                 <td>{{$order['items']['item_name']}}</td>
                 <td>{{$order['qty']}}</td>
                 <td>{{$order['items']['item_price']}}</td>
                 <td>{{$order['qty']*$order['items']['item_price']}}</td>
                 <td><button id="{{$order['items']['item_id']}}" class="btn btn-danger delcart">&times;</button></td>
             </tr>
         @endforeach
         @endif
        </tbody>
      </table>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#ordertable').DataTable();
            $('.delcart').click(function(){
              var cartid = this.id;
              $('#deletemodal').modal('show');
              $('#confidel').click(function(){
                $.ajax({
                  type: 'post',
                  url: "{{route('orderpull')}}",
                  data: {id: cartid},
                  success: function(data){
                    console.log("Deleted "+data);
                    table.ajax.reload();
                    $('#deletemodal').modal('hide');
                  },
                  error: function(data){
                  console.log(data.responseJSON.errors);
                }
                });
              });
            });
        });
    </script>
@endsection