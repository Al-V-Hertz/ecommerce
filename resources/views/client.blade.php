@extends('layouts.app')
@section('content')
<div class="container">
  @can('order item')
    <a href="/cart" class="btn btn-primary" style="margin-bottom: 10px; ">My Cart</a>
  @endcan
  @can('view order', 'order item')
    <a href="/myorders" class="btn btn-primary" style="margin-bottom: 10px; ">My Orders</a>
  @endcan
  <div class="jumbotron">
    <h1>Products</h1>
  </div>
    <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="order">
                <img id="detimg" src="" alt="Item-Image">
                <input id="detid" type="hidden" name="hidden_id">
                <h3 id="dettitle"></h3>
                <p id="dettext"></p>
                <span id="stock"></span><br><span id="price"></span><br>
                @can('order item')
                <label id="label" for="qty">Quantity </label>
                <input type="number" name="qty" id="qty" min="1" style='width: 55px; padding: 3px' placeholder="Qty" required>
                @endcan
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              @can('order item')
              <button id="atc" type="submit" form="order" class="btn btn-primary">Add to Cart</button>
              @endcan
            </div>
          </div>
        </div>
    </div>
      <div class="items">
          @foreach ($cards as $card)
          <div class="card">
            <img class="card-img-top" src={{$card->item_image}} alt="Card image cap">
            <div class="card-body">
              <form class="addtocart">
                <h5 class="card-title">{{$card->item_name}}</h5>
                <p class="card-text">Price: Php {{$card->item_price}}</p>
                <p class="card-text">Stock: {{$card->item_stock}}</p>
                <a id={{$card->id}} class="btn btn-info detailbtn" data-toggle="modal" data-target="#details">Details</a>
              </form>
            </div>
          </div>
          @endforeach
      </div>
</div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      //DETAILS MODAL
      $('.detailbtn').click(function(e){
        e.preventDefault();
        var get = this.id;
        $.get("details", {id: get},
          function(data){
            $('#detid').val(data.id);
            $('#detimg').attr("src", data.item_image);
            $('#dettitle').text(data.item_name);
            $('#dettext').text(data.item_desc);
            $('#price').text("Price: Php "+data.item_price);
            $('#stock').text("Stock/s: "+data.item_stock);
            $("#details").modal('show');
            if(data.item_stock == 0){
              $('#label').hide();
              $('#qty').hide();
              $('#atc').hide();
            }
          }
        )
        $('#label').show();
        $('#qty').show();
        $('#atc').show();
      })

      //ADD TO CART
      $("#order").submit(function(e){
        e.preventDefault();
        var fd = new FormData(this)
        $.ajax({
          type:"post",
          url:"addtocart",
          data: fd,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data){
            console.log("New Order: "+data)
            $("#details").modal("hide")
            $('form').trigger('reset')
          }
        })
      })


    })

  </script>
@endsection