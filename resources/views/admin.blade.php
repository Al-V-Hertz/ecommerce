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
              <button id ='findel' type="button" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>

      {{-- ADD TRIGGER --}}
        <div class="header">
            @role('superadmin')
            <a href='/control' class="btn btn-success"> <span><</span>Back </a>
            @endrole
            {{-- @can('add item') --}}
            <button class="btn btn-success" data-toggle="modal" data-target="#addForm">Add an Item</button>
            {{-- @endcan --}}
            @can('view order')
            <a href="/orders" class="btn btn-success">Orders</a>
            @endcan
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
      <div class="table">
          <table id="table" class="table-striped">
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
              @foreach($data as$key=>$item)
                <tr>
                  <td>{{$key+1}}</td>
                  <td> <img src={{$item->item_image}} alt="Nod Display"></td>
                  <td> {{$item->item_name}}</td>
                  <td>{{$item->item_desc}}</td>
                  <td>{{$item->item_price}}</td>
                  <td>{{$item->item_stock}}</td>
                  <td>
                    @can('edit item')
                      <button id={{$item->id}} class="btn btn-primary edit">Edit </button>
                    @endcan
                    @can('delete item')
                    <button id={{$item->id}} class="btn btn-danger delete">Delete </button>
                    @endcan
                  </td>
                </tr>
              @endforeach
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
          $('#table').DataTable();

          //CREATE//
          $('#form').submit(function(e){
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
              type: 'post',
              url: "{{route('additem')}}", 
              data: fd,
              cache: false,
              processData: false,
              contentType: false,
              success: function(data){
                console.log("New item : "+data);
                location.reload();
              }
            })
          $('#img').attr('src', 'img/Add.ico');
          $('#addForm').modal('hide');
        })

        //UPDATE//
        $("#table").on('click', '.edit', function(){
          // e.preventDefault();
          var edit_id = this.id;
          $.get("get", {id: edit_id},
                function(data){
                    // console.log("Fetched: "+data);
                    $('#uid').val(data.id);
                    $('#uimg').attr("src", data.item_image);
                    $('#upd-name').val(data.item_name);
                    $('#upd-desc').val(data.item_desc);
                    $('#upd-price').val(data.item_price);
                    $('#upd-stock').val(data.item_stock);
                    $("#updForm").modal('show');
                }
            )
        })
        $('#upd-form').submit(function(e){
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: "{{route('updateitem')}}",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data){
              console.log("Updated : "+data);
              $("#updForm").modal('hide');
              $('form').trigger('reset');
              location.reload();
            }
          })
        })

        //DELETE//
        $("#table").on('click', '.delete', function(e){
          e.preventDefault();
          var del_id = this.id;
          $('#deleteconfirm').modal('show');
          $('#findel').click(function(e){
            e.preventDefault();
            $.post("delitem", {id: del_id},
              function(data){
                console.log("Deleted "+data);
                $('#'+del_id).closest('tr').remove();
                $('#deleteconfirm').modal('hide');
              }
            )
          })
        })


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