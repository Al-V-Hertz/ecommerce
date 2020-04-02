@extends('layouts.app')
@section('content')
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
  </button> --}}
<div class="container">
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="order">
                <img src="" alt="Item-Image">
                <h3></h3>
                <p></p>
                <input type="hidden" name="item-id">
                <input type="number" name="qty" id="qty" min="1">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" form="order">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
      <div class="items">
          
      </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "GET",
                route: "{{ route('showitems') }}",
                success: function(data){
                  console.log(data);
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
            })
        });
    </script>
@endsection