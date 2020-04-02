@extends('layouts.app')
@section('content')
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
  </button> --}}
<div class="container">
    <a href="/cart" class="btn btn-primary" style="margin-bottom: 10px; ">My Cart</a>
  <div class="jumbotron">
    <h2>Products</h2>
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
              <form id="order" action="/addtocart" method="POST" enctype="multipart/form-data">
                @csrf 
                <img id="detimg" src="" alt="Item-Image">
                <input id="detid" type="hidden" name="hidden_id">
                <h3 id="dettitle"></h3>
                <p id="dettext"></p>
                <span id="stock"></span><br><span id="price"></span><br>
                <label id="label" for="qty">Quantity </label>
                <input type="number" name="qty" id="qty" min="1" style='width: 55px; padding: 3px' placeholder="Qty">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="atc" type="submit" form="order" class="btn btn-primary">Add to Cart</button>
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
      $('.detailbtn').click(function(e){
        e.preventDefault();
        var get = this.id;
        $.ajax({
          type: 'GET',
          url: "{{route('details')}}",
          data: {id: get},
          success: function(data){
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
          }, 
          error: function(data){
            console.log(data.responseJSON.errors);
          }
        });
        $('#label').show();
        $('#qty').show();
        $('#atc').show();
      });
    });
  </script>
@endsection