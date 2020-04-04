@extends('layouts.app')
@section('content')
    <div class="container">
      {{-- DELETE CONFIRMATION MODAL --}}
      <div class="modal fade" id="deleteconfirm" tabindex="-1" role="dialog" aria-labelledby="deleteconfirm" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteconfirm">Delete Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <h4>
               Are you sure you want to delete this item?
             </h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id ='findel' type="button" class="btn btn-danger">DELETE!!!</button>
            </div>
          </div>
        </div>
      </div>

      {{-- ADD TRIGGER --}}
        <div class="header">
            <button class="btn btn-success" data-toggle="modal" data-target="#addForm">Add an Item</button>
        </div>

      {{-- ADD MODAL --}}
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
                      <input type="number" class="form-control" id="item-price" name="price" min="1" step="0.01">
                    </div>
                    <div class="form-group">
                      <label for="item-stock">Stock</label>
                      <input type="number" class="form-control" id="item-stock" name="stock" min="0">
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
                        <input type="file" class="form-control" id="upd-image" name="uimage" style="display: none">
                        <input type="text" name="uid" id="uid" style="display: none">
                      </div>
                    <div class="form-group">
                      <label for="item-name">Item Name:</label>
                      <input type="text" class="form-control" id="upd-name" name="uname">
                    </div>
                    <div class="form-group">
                      <label for="item-name">Item Description:</label>
                      <textarea class="form-control" id="upd-desc" name="udesc"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="item-price">Item Price:</label>
                      <input type="number" class="form-control" id="upd-price" name="uprice" min="1" step="0.01">
                    </div>
                    <div class="form-group">
                      <label for="item-stock">Stock</label>
                      <input type="number" class="form-control" id="upd-stock" name="ustock" min="0">
                    </div>
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" form="upd-form" id="btn-update">Update</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div>
          <table id="table">
            <thead>
              <th></th>
              <th>Image</th>
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
                {data: 'item_image', name: 'timage', render: function(data, type, row){
                  return "<img src = "+data+" width = '70', height= '70' alt='Not Found' />";
                }},
                {data: 'item_name', name: 'tname'},
                {data: 'item_desc', name: 'tdesc'},
                {data: 'item_price', name: 'tprice'},
                {data: 'item_stock', name: 'tstock'},
                {data: 'action', name: 'action'},
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
                cache: false,
                processData: false,
                contentType: false,
                success: function(data){
                    console.log("New item : "+data);
                    table.ajax.reload();
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
          });
          $('#img').attr('src', 'img/Add.ico');
          $('#addForm').modal('hide');
          this.reset();
        });

        //UPDATE//
        $("#table").on('click', '.edit', function(){
          // e.preventDefault();
          var edit_id = this.id;
          $.ajax({
                type: 'GET',
                url: "{{ route('get') }}",
                data: {id: edit_id},
                success: function(data){
                    // console.log("Fetched: "+data);
                    $('#uid').val(data.id);
                    $('#uimg').attr("src", data.item_image);
                    $('#upd-name').val(data.item_name);
                    $('#upd-desc').val(data.item_desc);
                    $('#upd-price').val(data.item_price);
                    $('#upd-stock').val(data.item_stock);
                    $("#updForm").modal('show');
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
            });
        });
        $('#upd-form').submit(function(){
              var formData = new FormData(this);
              $.ajax({
                type: 'POST',
                url: "{{route('updateitem')}}",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data){
                    window.location.href = "/admin";
                    console.log("Updated : "+data);
                    table.ajax.reload();
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
              });
              this.reset();
        });
        //DELETE//
        $("#table").on('click', '.delete', function(e){
          e.preventDefault();
          var del_id = this.id;
          $('#deleteconfirm').modal('show');
          $('#findel').click(function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('delitem') }}",
                data: {id: del_id},
                success: function(data){
                  console.log("Deleted "+data);
                  table.ajax.reload();
                  $('#deleteconfirm').modal('hide');
                },
                error: function(data){
                  console.log(data.responseJSON.errors);
                }
            })
         });
        });
      //FILE CHANGE//
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