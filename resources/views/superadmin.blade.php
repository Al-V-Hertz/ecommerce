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
            <button class="btn btn-success" data-toggle="modal" data-target="#addUser">Add User</button>
            <a href="/roles" class="btn btn-success">Roles</a>
        </div>

      {{-- ADD MODAL --}}
      <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addUser">Add User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="addUser">
                <form id="addForm" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="addname">Name</label>
                      <input type="text" class="form-control" id="addname" name="addname" required>
                    </div>
                    <div class="form-group">
                      <label for="addemail">Email</label>
                      <input type="email" class="form-control" id="addemail" name="addemail">
                    </div>
                    <div class="form-group">
                      <label for="addpassword">Password</label>
                      <input type="password" class="form-control" id="addpassword" name="addpassword">
                    </div>
                    <div class="form-group">
                      <label for="conpassword">Confirm Password</label>
                      <input type="password" class="form-control" id="conpassword" name="conpassword">
                    </div>
                    <div class="form-group">
                      <label for="addroles">Assign Role</label>
                      <select class="form-control" id="addrole" name="addrole">
                        
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="existingpm">Permission/s</label>
                      <ul id="existingpm">

                      </ul>
                    </div>
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" form="addForm" id="btn-create">Submit</button>
            </div>
          </div>
        </div>
      </div
      >
      {{-- UPDATE MODAL --}}
      <div class="modal fade" id="updUser" tabindex="-1" role="dialog" aria-labelledby="updUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updForm">Update Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="updForm">
                <form id="upd-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="updid" name="updid">
                      <label for="updname">User Name:</label>
                      <input type="text" class="form-control" id="updname" name="updname">
                    </div>
                    <div class="form-group">
                      <label for="updemail">Email</label>
                      <input type="text" class="form-control" id="updemail" name="updemail">
                    </div>
                    <div class="form-group">
                      <label for="updpassword">Password</label>
                      <input type="password" class="form-control" id="updpassword" name="updpassword" placeholder="Change Password?">
                    </div>
                    <div class="form-group">
                      <label for="updrole">Role</label>
                      <select class="form-control" id="updrole" name="updrole">
                        
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="permission">Permission/s</label>
                      <ul id="permission">

                      </ul>
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
      <br>
       <div>
          <table id="usertable" class="table-striped">
            <thead>
              <tr>
                <th></th>
                <th>User</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>  
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
      //retrieve
      var table = $('#usertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
          {data: 'name', name: 'name'},
          {data: 'email', name: 'email'},
          {data: 'action', name: 'action'},
        ]
      })

      //create-show existing roles and permissions
      $("#addUser").on("shown.bs.modal", function(e){
        e.preventDefault();
        $("#addrole option").remove();
        $("#existingpm li").remove();
        $.get("getroles", function(data){
          $("#addrole").append("<option></option>")
          $.each(data, function(index, role){
            $("#addrole").append("<option>"+role.name+"</option>")
          })
        })
      })
      
      //create-every time role-selection change...
      $("#addrole").change(function(){
        $("#existingpm li").remove();
        $.get("getpermissions/"+$("#addrole").val(), function(data){
          $.each(data.pm, function(index, pemi){
            $("#existingpm").append("<li>"+pemi.name+"</li>")
          })
        })
      })

      //create-submit form
      $("#addForm").submit(function(e){
        e.preventDefault();
        var fd = new FormData(this);
        $.ajax({
          type: "post",
          url: "adduser",
          data: fd,
          cache: false,
          processData: false,
          contentType: false, 
          success: function(response){
            console.log("Added: "+response);
            table.ajax.reload();
          }
        });
      });

      //delete
      $("#usertable").on("click", ".delete", function(e){
          e.preventDefault();
          var del_id = this.id;
          $('#deleteconfirm').modal('show');
          $('#findel').click(function(e){
            e.preventDefault();
            $.post("deleteuser", {id: del_id},
              function(data){
                console.log("Deleted "+data);
                table.ajax.reload();
                $('#deleteconfirm').modal('hide');
              }
            )
          })
      })
      
      //update-getdata
      $("#usertable").on("click", ".edit", function(e){
          e.preventDefault();
          var i = this.id;
          $.get("getuser/"+i, function(data){
            $("#permission li").remove();
            $("#updrole option").remove();
            $("#updid").val(data.user.id)
            $("#updname").val(data.user.name);
            $("#updemail").val(data.user.email);
            $("#updpassword").val(data.user.password);
            $("#updrole").append("<option id='selected' value="+data.user.roles[0].name+" selected>"+data.user.roles[0].name+"</option>");
            $.each(data.roles, function(index, role){
              $('#updrole').append("<option value="+role.name+">"+role.name+"</option>");
            })
            $.each(data.perms, function(index, perm){
              $("#permission").append("<li>"+perm.name+"</li>")
            })
            $("#updUser").modal('show');
            $("#updrole").change(function(){
              $("#permission li").remove();
              $.get("getpermissions/"+$("#updrole").val(), function(data){
                $.each(data.pm, function(index, pemi){
                  $("#permission").append("<li>"+pemi.name+"</li>")
                })
              })
            })
          })

      })

      //update-submit
      $('#upd-form').submit(function(e){
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: "{{route('updateuser')}}",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data){
              console.log("Updated : "+data);
              $("#updUser").modal('hide');
              table.ajax.reload();
            }
          })
        })
    })
</script>
@endsection