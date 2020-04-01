@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addForm">Add an Item</button>
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
                <img id="img" src="{{asset('img/Add.ico')}}">
               </div>
              <div id="addItem">
                <form id="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="item-image" style="display: none">Item Image:</label>
                        <input type="file" class="form-control" id="item-image" name="image" style="display: none">
                      </div>
                    <div class="form-group">
                      <label for="item-name">Item Name:</label>
                      <input type="text" class="form-control" id="item-name" name="name">
                    </div>
                    <div class="form-group">
                      <label for="item-name">Item Description:</label>
                      <textarea class="form-control" id="item-desc" name="desc"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="item-price">Item Price:</label>
                      <input type="number" class="form-control" id="item-price" name="price">
                    </div>
                    <div class="form-group">
                      <label for="item-stock">Stock</label>
                      <input type="number" class="form-control" id="item-stock" name="stock">
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
      <br>
      <div>
          <table>
            <thead>
              <th></th>
              <th>Image</th>
              <th>Item</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Action</th>
            </thead>
            <tbody>
            </tbody>
          </table>  
        </div>
    </div>
@endsection
@section('scripts')
<script>
  function preview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
     }
  }
    $(document).ready(function(){
          $.ajax({
            type: 'GET',
            url: "{{ route('getitem') }}",
            data: 
            success: function(data){
              console.log(data.result);
            }
            
          }),
          $('#form').submit(function(e){
          e.preventDefault();
          var fd = new FormData(this);
          $.ajax({
                type: 'POST',
                url: "{{ route('additem') }}",
                data: fd,
                processData: false,
                contentType: false,
                success: function(data){
                    console.log(data);
                    window.location.href ='/admin';
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
          });
        }),
        $('#img').click(function(){
          $("#item-image").click();
        }),
        $('#item-image').change(function(){
          preview(this);
        });
    })
</script>
@endsection