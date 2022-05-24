@extends('layouts.adminTemplate')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">  

@section('content')

<div class="content-wrapper">
    <br>
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status')}}
            </div>
        @endif

    </div>

    <!-- Top Header-->
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>User Management</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a href="{{ route('users.create') }}" class="btn btn-success">Create New User</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th width="200px">Action</th>
                    </tr>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->type }}
                            {{--@if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label>{{ $v }}</label>
                                @endforeach
                            @endif--}}
                        </td>
                        <td>
                            
                            <label><a href="javascript:void(0)" id="show-users" data-url="{{ route('users.edit',$user->id)}} " class="btn btn-primary">Edit</a></label>
                            <label><form class="delete" method="POST" action="{{ route('users.destroy', $user->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-danger show_confirm">Delete</button>
                            </form></label>
                            {{--<a href="" class="btn btn-danger">Delete</a>
                            {{--<a href=" {{ route('users.edit',$user->id)}} " class="btn btn-primary">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>--}}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
        </div>
    </div>
    <div class="d-flex justify-content-center"> {{$data->links()}} </div>
</div>

modal for edit user role type
<div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User Role Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/users/update/'.$user->id)}}" method="POST" id="editForm_{{$user->id}}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="id" name="id" value="{{$user->id}}">
                    <div class="row">
                        <label for="Name">Name: </label>
                        <input type="text" id="name" name="name" value="{{$user->name }}" class="form-control" required placeholder="Name">
                    </div>

                    <div class="row">
                        <label for="Username">Username: </label>
                        <input type="text"  id="username" name="username" value="{{$user->username }}" class="form-control" required placeholder="Username">
                    </div>

                    <div class="row">
                        <label for="role_type">Role Type:</label>
                        {{--<input type="checkbox" name="type[]" id="type[]" value="0" {{ in_array('user', $type) ? 'checked' : ''}}>user
                        <input type="checkbox" name="type[]" id="type[]" value="1" {{ in_array('admin', $type) ? 'checked' : '' }}>admin--}}
                        <select name="type[]" id="type" class="form-control">
                            <option value="admin"
                                @if ($user->type)
                                    @checked(true)
                                @endif>Admin</option>
                            <option value="user"
                            @if ($user->type)
                                @checked(true)
                            @endif>User</option>
                        </select>
                        {{--<input type="text"  id="type" name="type[]" value="{{$user->type }}" class="form-control" required placeholder="Role Type">--}}
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" type="submit" class="btn btn-primary" id="update_data" name="save_button">Update</button>
                <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>

{{--Script--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>--}}
<script type="text/javascript">

$(function (e) {

    $(document).ready(function () {
           
           /* When click show user */
            $('body').on('click', '#show-users', function (e) {
                e.preventDefault();
              var usersURL = $(this).data('url');
              $.get(usersURL, function (data) {
                  $('#editRole').modal('show');
                  $('#id').val(data.id);
                  $('#name').val(data.name);
                  $('#username').val(data.username);
                  $('#type').val(data.type);
              });
           });   
    });  
});


</script>

<script>
$(document).ready(function () {
    
    $(document).on("click", "#update_data", function (e) {
        e.preventDefault();
       var url = "{{ URL('/admin/users/update'.$user->id)}}";
       var id= 
                $.ajax({
                    url: url,
                    type: "PUT",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                                    type: 3,
                                    name: $(name).val();
                                    username: $(username).val();
                                    type: $(type).val();

                    },
                    success: function(dataResult){
                        dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode)
                        {
                            window.location= "/admin/users";
                        }
                        else
                        {
                            alert("Internal Server Error");
                        }
                    }
                });
    });
});
</script>

{{--end of script for modal--}}

{{-- Script for confirmation deletion--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">

    $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var todo = $(this).data("todo");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete thi user?`,
              text: "If you delete this, user records will be deleted.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
</script>
@endsection