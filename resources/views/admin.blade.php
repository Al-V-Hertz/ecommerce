@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="header">
            <button class="btn btn-success" data-toggle="modal" data-target="#addForm">Add an Item</button>
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
              <div id="addItem">
                <form id="form" enctype="multipart/form-data">
                  <div class="img" style="margin-left: 40%">
                    <img id="img" src="{{asset('img/Add.ico')}}">
                   </div>
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
      </div
      >
      {{-- UPDATE MODAL --}}
      <div class="modal fade" id="updForm" tabindex="-1" role="dialog" aria-labelledby="updForm" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updForm">Update Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="updItem">
                <form id="upd-form" enctype="multipart/form-data">
                  <div class="img" style="margin-left: 40%">
                    <img id="uimg" src="{{asset('img/Add.ico')}}">
                   </div>
                    <div class="form-group">
                        <label for="item-image" style="display: none">Item Image:</label>
                        <input type="file" class="form-control" id="upd-image" name="image" style="display: none">
                      </div>
                    <div class="form-group">
                      <label for="item-name">Item Name:</label>
                      <input type="text" class="form-control" id="upd-name" name="name">
                    </div>
                    <div class="form-group">
                      <label for="item-name">Item Description:</label>
                      <textarea class="form-control" id="upd-desc" name="desc"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="item-price">Item Price:</label>
                      <input type="number" class="form-control" id="upd-price" name="price">
                    </div>
                    <div class="form-group">
                      <label for="item-stock">Stock</label>
                      <input type="number" class="form-control" id="upd-stock" name="stock">
                    </div>
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" form="form" id="btn-update">Update</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div>
          <table id="table">
            <thead>
              <th></th>
              {{-- <th>Image</th> --}}
              <th>Item</th>
              <th>Description</th>
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
  function preview(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
     }
  }
    $(document).ready(function(){
          //RETRIEVE//
          var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('getitem') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'item_image', name: 'timage'},
                {data: 'item_name', name: 'tname'},
                {data: 'item_desc', name: 'tdesc'},
                {data: 'item_price', name: 'tprice'},
                {data: 'item_stock', name: 'tstock'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });

          //CREATE//
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
                    console.log("New item : "+data);
                    table.ajax.reload();
                    $('#addForm').modal('toggle');
                    $(this).reset();
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
          })
        });

        //UPDATE//
        $("#table").on('click', '.edit', function(e){
          e.preventDefault();
          var edit_id = this.id;
          $.ajax({
                type: 'GET',
                url: "{{ route('get') }}",
                data: {id: edit_id},
                success: function(data){
                    console.log(data);
                    $('#uimg').attr("src", data.item_image);
                    $('#upd-name').val(data.item_name);
                    $('#upd-desc').val(data.item_desc);
                    $('#upd-price').val(data.item_price);
                    $('#upd-stock').val(data.item_stock);
                    $("#updForm").modal('toggle');
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
            }),
            $('#upd-form').submit(function(){
              var fd = new FormData(this);
              $.ajax({
                type: 'POST',
                url: "{{ route('additem') }}",
                data: {
                  fd,
                  id: edit_id
                },
                success: function(data){
                    console.log("Updated : "+data);
                    table.ajax.reload();
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
              })
            })
        }),
        $('#img').click(function(){
          $("#item-image").click();
        }),
        $('#item-image').change(function(){
          preview(this, "#img");
        }),
        $('#uimg').click(function(){
          $("#upd-image").click();
        }),
        $('#upd-image').change(function(){
          preview(this, "#uimg");
        });
    });
</script>
@endsection