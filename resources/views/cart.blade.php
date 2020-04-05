@extends('layouts.app')
@section('content')
<div class="container">
    <div class="notifs"></div>
    {{-- CHECKOUT TRIGGER --}}
    <button class="btn btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#checkout">Proceed to Checkout</button>

    {{-- CHECKOUT MODAL --}}
    @if(Session::has('orders'))
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
              <table class="table-striped">
                <thead>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </thead>
                <?php $gtotal = 0; ?>
                <tbody>
                  @foreach(Session::get('orders') as $order)
                    <tr>
                        <td>{{$order['items']->item_name}}</td>
                        <td>{{$order['qty']}}</td>
                        <td>Php {{$order['items']->item_price}}</td>
                        <td>Php {{$order['qty']*$order['items']->item_price }}</td>
                        <?php $gtotal+=($order['qty']*$order['items']->item_price)?>
                    </tr>
                  @endforeach
                </tbody>
                {{-- <hr> --}}
                <tfoot class="table-dark">
                <tr>
                    <td><h6><strong> Grand Total:</strong></h6></td>
                    <td></td>
                    <td></td>
                    <td><h6 id="gtotal"><strong>Php <?php echo $gtotal?><strong></h6></td>
                </tr>
              </tfoot>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              @if(Session::get('orders') != NULL)
                <button id="sendorder" type="submit" class="btn btn-primary">Checkout Order</button>
              @endif
            </div>
          </div>
        </div>
    </div>
    @endif
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
            <button id ='confidel' type="button" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>

    
    {{-- TABLE --}}

    <div class="jumbotron">
        <h1>My Cart</h1>
    </div>
    @if(Session::has('orders'))
    <table class="table-striped" id="ordertable">
      <thead>
        <th></th>
        <th>Ordered Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th></th>
      </thead>
      <tbody>
         @foreach(Session::get('orders') as $key=>$order)
             <tr>
                 <td><img id="orderimg" src={{$order['items']['item_image']}}></td>
                 <td>{{$order['items']['item_name']}}</td>
                 <td>{{$order['qty']}}</td>
                 <td>Php {{$order['items']['item_price']}}</td>
                 <td>Php {{$order['qty']*$order['items']['item_price']}}</td>
                 <td><button id="{{$key}}" class="btn btn-danger delcart">&times;</button></td>
             </tr>
         @endforeach
        </tbody>
      </table>
      @endif
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#ordertable').DataTable();
            $('.delcart').click(function(){
              var cartid = this.id;
              $('#deletemodal').modal('show');
              $('#confidel').click(function(e){
                e.preventDefault();
                $.ajax({
                  type: 'post',
                  url: "{{ route('orderpull') }}",
                  data: {id: cartid},
                  success: function(response){
                    console.log("Deleted "+response);
                    $('#deletemodal').modal('hide');
                    window.location = response
                  }
                });
              });
            });
            $('#sendorder').click(function(e){
              e.preventDefault();
              $.ajax({
                type: "get",
                url: "addorders",
                success: function(data){
                  $('#checkout').modal('hide');
                  if($.trim(data)){
                    alert(data);
                  }
                  window.location.href = "/client";
                  // $.each(data, function(key, value){
                  //   $(".notifs").append("<div class='alert alert-danger' role='alert'>"+value+"</div>");
                  // });
                }
              });
            });
        });
    </script>
@endsection