@extends('layouts.adminTemplate')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">  

@section('content')

<div class="content-wrapper">
    <br>
    <br>

    <!-- Top Header-->
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>Next Week Task List</h2>
        </div>
    </div>

    <br>

    {{--Search for employee's--}}
    <div class="row justify-content-center">
            {{-- Search for staff --}}
            <div class="col-md-9">
                <form action="{{ route('Admintasks.search')}}">
                    <div class="input-group mb-5">
                        <!--<input type="text" class="form-control" placeholder="Search..." name="search">-->
                        <select name="search" class="form-control" value="{{request('search')}}">
                            <option class="text-center">Search Employee</option>
                            @foreach ($users as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
        </div>
    </div>


    {{-- For Add New Task --}}
    <br>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <a class="btn btn-success" href="{{ route('Admintodos.create') }}"> Add New Tasks</a>
          </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <p>Current Week Number: {{ \Carbon\Carbon::now()->weekOfYear; }}</p>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    @if (request()->has('search'))
                        <th> No </th>
                        <th> Staff Name </th>
                        <th> Project </th>
                        <th> Task </th>
                        <th> Status </th>
                        <th width="120px"> Created At </th>
                    @else
                        <th> No </th>
                        <th> Project </th>
                        <th> Task </th>
                        <th> Status </th>
                        <th width="120px"> Created At </th>
                        <th width="190px"> Action </th>
                    @endif
                </tr>
                @foreach ($new_todo as $key => $item)
                <tr>
                    @if (request()->has('search'))
                        <td> {{ $new_todo->firstItem() + $key }} </td>
                        <td> {{ $item->user->name}} </td>
                        <td> {{ $item->projects->name}} </td>
                        <td> {{ $item->todo}} </td>
                        <td> 
                            @if (($item->status_id) == '1')
                                <a style="color: green ">{{$item->status->name}}</a>
                            @else
                                <a>{{$item->status->name}}</a>
                            @endif
                        </td>
                        <td> {{ $item->effort_hours }} </td>
                        <td> {{ $item->created_at->format('j F Y g:i A') }} </td>
                    @else
                        <td> {{ $new_todo->firstItem() + $key }} </td>
                        <td> {{ $item->projects->name}} </td>
                        <td> {{ $item->todo}} </td>
                        <td> 
                            @if (($item->status_id) == '1')
                                <a style="color: green ">{{$item->status->name}}</a>
                            @else
                                <a>{{$item->status->name}}</a>
                            @endif
                        </td>
                        <td> {{ $item->created_at->format('j F Y g:i A') }} </td>
                        <td> 
                            @if(($item->status_id) == '1')
                                <a style="color:green">Good Job!</a>
                            @else

                                <label><a href="javascript:void(0)" id="show-todos" data-url="{{ route('Admintodos.edit',$item->id)}}" class="btn btn-primary">Edit</a></label>
                                <label><form class="delete" method="POST" action="{{ route('Admintodos.destroy', $item->id) }}">
                                    @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger show_confirm">Delete</button>                                           
                                </form></label>  
                            @endif
                        </td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

{{--Modal For Update Progress and Effort Hours--}}
@foreach( $new_todo as $item)
@if($item != '')
<div class="modal fade" id="todosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/admin/todos/update/'.$item->id)}}" method="POST" id="editForm_{{$item->id}}">
                @csrf
                @method('PUT')

                <input type="hidden" id="id" name="id" value="{{$item->id}}">
                <div class="row">
                    <label for="">Project:</label>
                    <select required name="project_id" class="form-control" id="project_id">
                        <option value="">--Choose Project--</option>
                        @foreach ($projects as $id => $name)
                        <option 
                            value="{{$id}}" {{ (isset($new_todo['project_id']) && $new_todo['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <label for="">Task:</label>
                    <input type="text" id="todo" name="todo" value="{{$item->todo }}" class="form-control" required placeholder="Task">
                </div>

                <div class="row">
                    <label for="">Status:</label>
                    <select required name="status_id" class="form-control" id="status_id">
                        <option value="">--Choose Status--</option>
                        @foreach ($statuses as $id => $name)
                        <option 
                            value="{{$id}}" {{ (isset($new_todo['status_id']) && $new_todo['status_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update_data" name="save_button">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
      </div>
    </div>
</div>
@endif
@endforeach

{{-- Modal edit --}}
<script type="text/javascript">

    //For modal 
    $(document).ready(function () {
           
           /* When click show user */
            $('body').on('click', '#show-todos', function () {
              var todosURL = $(this).data('url');
              $.get(todosURL, function (data) {
                $('#todosModal').modal('show');
                $('#id').val(data.id);
                $('#todos_id').val(data.id);
                $('#project_id').val(data.project_id);
                $('#todo').val(data.todo);
                $('#status_id').val(data.status_id);
              })
           });
    
        
           
    });  
</script>
<script>
    $(document).ready(function () {

        $(document).on("click", "#update_data", function (e) {
            e.preventDefault();
           var id= 
                    $.ajax({
                        url: url,
                        type: "PUT",
                        cache: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                                        type: 3,
                                        id: $(id).val();
                                        project_id: $(project_id).val();
                                        todo: $(todo).val();
                                        status_id: $(status).val();
                        },
                        success: function(dataResult){
                            dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode)
                            {
                                window.location= "/admin/todos";
                            }
                            else
                            {
                                alert("Internal Server Error");
                            }
                        }
                    });
       });
    })
</script>


{{-- Delete Confirmation alert--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var todo = $(this).data("todo");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this task?`,
              text: "If you delete this, it will be gone forever.",
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