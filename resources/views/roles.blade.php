 @extends('layouts.app')
 @section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> Something's Wrong<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
         @endif
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
             <a href="/control" class="btn btn-success"> <span><</span> Back </a>
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
                    <div  id="cbox" class="form-group">
                      <label>Permissions</label>
                      
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
              <h5 class="modal-title" id="updRole">Edit Role</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="updRole">
                <form id="updForm" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="updrolename">Role</label>
                      <input type="hidden" id="updid" name="updid">
                      <input type="text" class="form-control" id="updrolename" name="updrolename" required>
                    </div>
                    <div id="updcbox" class="form-group">
                      <label>Permissions</label>
                      {{-- loop goes here --}}
                    </div>
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" form="updForm" id="btn-upd">Submit</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
       <div class="table">
          <table id="roletable" class="table-striped">
            <thead>
              <tr>
                <th></th>
                <th>Role</th>
                <th>Permissions</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key => $role)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <ul>
                            @foreach($role->permissions as $pm)
                                <li>{{$pm->name}}</li>
                            @endforeach
                        </ul> 
                    </td>
                    <td>
                        <button id={{$role->id}} class="btn btn-primary editrole">Edit</button>
                        <button id={{$role->id}} class="btn btn-danger delrole">Delete</button>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>  
        </div>
    </div>
    </div>
 @endsection
 @section('scripts')
 <script>
     $(document).ready(function(){
        var table = $('#roletable').DataTable();
         $.get("getallperm", function(data){
             $.each(data, function(i, v){
                 $("#cbox").append("<div class='checkbox'><label> <input type='checkbox' value="+v.id+">"+v.name+"</label></div>")
             })
         })

         //create
         $("#addForm").submit(function(e){
             e.preventDefault();
            var role = $("#addname").val(); 
            var pm = [];
            $(":checkbox:checked").each(function(i){
                pm[i] = $(this).val();
            });
            $.ajax({
                type: 'post',
                url: "{{route('addrole')}}", 
                data: {role: role, pm: pm},
                success: function(data){
                    console.log(data)
                    $("#addRole").modal("hide");
                    $('form').trigger('reset')
                    location.reload();
                }
            })
         })

         //delete role
         $("table").on("click", ".delrole", function(e){
          e.preventDefault();
          var del_id = this.id;
          $('#deleteconfirm').modal('show');
          $('#findel').click(function(){
            $.post("deleterole", {id: del_id},
              function(data){
                console.log("Deleted "+data);
                $("#"+del_id).closest("tr").remove();
                $("#deleteconfirm").modal("hide");
              }
            )
          })
        })

        // edit- retrieve
        $("table").on("click", ".editrole", function(e){
          e.preventDefault();
          var i = this.id;
            $.get("getrole/"+i, function(data){
                $('#updcbox div').remove();
                $("#updrolename").val(data.role.name);
                $("#updid").val(i);
                $.each(data.allperm, function(i, v){
                    $("#updcbox").append("<div class='checkbox'><label> <input id="+v.id+" type='checkbox' value="+v.id+">"+v.name+"</label></div>");
                })
                $.each(data.perm, function(x, y){
                    $("#"+y.id).prop('checked', true);
                })
            $("#updRole").modal('show');
            })
        })

        // edit - submit
        $("#updForm").submit(function(e){
            e.preventDefault();
            var name = $("#updrolename").val();
            var id = $("#updid").val(); 
            var upm = [];
            $(":checkbox:checked").each(function(i){
                upm[i] = $(this).val();
            });
            $.ajax({
                type: 'post',
                url: "{{route('updrole')}}", 
                data: {id: id, pm: upm, name: name},
                success: function(data){
                    console.log(data)
                    $("#updRole").modal("hide");
                    $('form').trigger('reset');
                    location.reload();
                }
            })
        })
    })
 </script>
     
 @endsection