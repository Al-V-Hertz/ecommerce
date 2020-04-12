 @extends('layouts.app')
 @section('content')
    <div class="container">
         {{-- delete ocnfirmation modal --}}
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
                 <h4>Are you sure you want to delete this item? </h4>
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
             <a href={{URL::previous()}} class="btn btn-success"> <span><</span> Back </a>
            <button class="btn btn-success" data-toggle="modal" data-target="#addRole">Add Role</button>
        </div>
        
        {{-- ADD MODAL --}}
      <div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRole" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addRole">Add Role</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="addRole">
                <form id="addForm" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="addname">Role</label>
                      <input type="text" class="form-control" id="addname" name="addname" required>
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
      </div>

      {{-- UPDATE MODAL --}}
      <div class="modal fade" id="updRole" tabindex="-1" role="dialog" aria-labelledby="updRole" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updForm">Update Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="updRole">
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
                <th>Role</th>
                <th>Permissions</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>  
        </div>
    </div>
    </div>
 @endsection
 @section('scripts')
 <script>
     $(document).ready(function(){
        var table = $('#usertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getroles') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
          {data: 'name', name: 'name'},
          {data: 'permissions', name: 'permissions'},
          {data: 'action', name: 'action'},
        ]
      })
     })
 </script>
     
 @endsection