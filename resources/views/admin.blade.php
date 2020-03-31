@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addForm">Add an Item</button>
        </div>
    </div>
    <div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="addForm" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addForm">Add Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="img" style="margin-left: 40%">
                <img src="{{asset('img/Add.ico')}}">
               </div>
              <div id="addItem">
                <form id="form">
                    <div class="form-group">
                        <label for="item-image">Item Image:</label>
                        <input type="file" class="form-control" id="item-image" name="item-image">
                      </div>
                    <div class="form-group">
                      <label for="item-name">Item Name:</label>
                      <input type="text" class="form-control" id="item-name" name="item-name">
                    </div>
                    <div class="form-group">
                      <label for="item-price">Item Price:</label>
                      <input type="number" class="form-control" id="item-price" name="item-price">
                    </div>
                    <div class="form-group">
                      <label for="item-stock">Stock</label>
                      <input type="number" class="form-control" id="item-stock" name="item-stock">
                    </div>
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" form="form" id="btn-create">Submit</button>
            </div>
          </div>
        </div>
      </div>
      <div>
          <table>

          </table>  
      </div>      
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        // $.ajax({
        //   type: "GET",
        //   url: "{{ route('getitem') }}",
        //   dataType: 'json',
        //   data: {
        //     items
        //   },
        //   success: function(res){
        //     console.log();
        //   }
        // }),
        $('#btn-create').click(function(e){
            e.preventDefault();
            var itemname = $("#item-name").val();
            var itemprice = $("#item-price").val();
            var itemstock  = $("#item-stock").val();
            $.ajax({
                type: "POST",
                url: "{{ route('additem') }}",
                data: {
                    itemname,
                    itemprice,
                    itemstock
                },
                success: function(){
                    alert('Item Added Successfully');
                    window.location.href="/admin";
                }
            })
        })
    })
</script>
@endsection