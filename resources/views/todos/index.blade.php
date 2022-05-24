@extends('layouts.template')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">  

@section('content')

<div class="content-wrapper">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif
        </div>

            <!-- Header-->
            <br> 
            <div class="mb-3 text-center">
                <div class="col-lg-12 margin-tb">
                    <h2>Next Week Tasks</h2>
                </div>
            </div>


            <br>
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <a class="btn btn-success" href="{{ route('todos.create') }}"> Add New Tasks</a>
                    </div>
                </div>
            </div>

            <!-- Starting the table for display New To Do List-->
            <div class="card">
                <div class="card-header">
                    <div class="text-right">

                        <a href="" class="btn btn-danger btn-sm" id="deleteAllSelectedTask">Delete All Selected</a>

                        {{-- Completed Task --}}
                        @if(request()->has('view_completed'))

                            <a href="{{ route('todos.index') }}" class="btn btn-info btn-sm">View All Tasks</a>

                        @else

                            <a href="{{ route('todos.showcompleted' , ['view_completed']) }}" class="btn btn-primary btn-sm">View Completed Tasks</a>
                        
                        @endif

                        {{--Deleted Tasks--}}

                        @if(request()->has('view_deleted'))

                            <a href="{{ route('todos.index') }}" class="btn btn-info btn-sm">View All Tasks</a>

                        @else

                            <a href="{{ route('todos.showDeleted', ['view_deleted']) }}" class="btn btn-primary btn-sm">View Deleted Tasks</a>

                        @endif

                    

                    </div>
                </div>

                <div class="card-boday">
                <table class="table">
                    <tr>
                        <th><input type="checkbox" id="chkCheckAll"></th>
                        <th>No</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Created_at</th>
                        <th width="190px">Action</th>
                        <th></th>
                    </tr>
                    @foreach ($new_todo as $key => $m)                                   
                    
                    <tr id="tid{{$m->id}}">
                        <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$m->id}}"></td>
                        <td>{{ $new_todo->firstItem() + $key }}</td>
                        <td>{{$m->projects->name}}</td>
                        <td>{{$m->todo}}</td>
                        <td>
                            @if (($m->status_id) == '1')
                                <a style="color: green ">{{$m->status->name}}</a>
                            @else
                                <a>{{$m->status->name}}</a>
                            @endif
                        </td>
                        <td>{{$m->created_at->format('j F Y g:i A')}}</td>
                        <td>
                            @if(($m->status_id) == '1')
                                <a style="color:green">Good Job!</a>
                            @else

                                <label><a href="javascript:void(0)" id="show-todos" data-url="{{ route('todos.edit', $m->id)}}" class="btn btn-primary">Edit</a></label>
                                <label><form class="delete" method="POST" action="{{ route('todos.destroy', $m->id) }}">
                                    @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger show_confirm">Delete</button>                                           
                                </form></label>  
                            @endif  
                        </td>   
                    </tr>
                    @endforeach
                </table>
                <br>
                <div class="d-flex justify-content-center"> {{$new_todo->links()}} </div>
                </div>
            </div>
</div>
{{--Modal For Update Progress and Effort Hours--}}
@foreach( $new_todo as $m)
@if($m != '')
<div class="modal fade" id="todosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/todos/update/'.$m->id)}}" method="POST" id="editForm_{{$m->id}}">
                @csrf
                @method('PUT')

                <input type="hidden" id="id" name="id" value="{{$m->id}}">
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
                    <input type="text" id="todo" name="todo" value="{{$m->todo }}" class="form-control" required placeholder="Task">
                </div>

                <div class="row">
                    <label for="">Status:</label>
                    <select required name="status_id" class="form-control" id="status_id">
                        <option value="">--Choose Status--</option>
                        @foreach ($statuses as $id => $name)
                        <option 
                            value="{{$id}}" {{ (isset($new_todos['status_id']) && $new_todo['status_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
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
<script type="text/javascript">

$(function(e){

    //select all checkbox
    $('#chkCheckAll').click(function(event){
        $('.checkBoxClass').prop('checked', $(this).prop('checked'));
    });
    

    //for delete button
    $("#deleteAllSelectedTask").click(function(e) {
        e.preventDefault();
        //arrray for id
        var allids = [];


        //check if the data is tick/checked for deletion or not
        $("input:checkbox[name=ids]:checked").each(function() {
            allids.push($(this).val());
        });

        swal ({ 
            title: "Are you sure you want to delete all tasks?",
            text:  "If you want to delete all this tasks, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if(willDelete) {
                $.ajax({
                    url:"{{ route('todos.deleteSelected')}}",
                    type:"DELETE",
                    data:{
                        _token:$("input[name=_token]").val(),
                        ids:allids
                    },
                    success:function(response){
                        $.each(allids, function( key, val) {
                             $("#tid"+val).remove();
                            })    
                    }
                });
            }
        })

    });

    //For modal 
    $(document).ready(function () {
           
           /* When click show user */
            $('body').on('click', '#show-todos', function (e) {
                e.preventDefault();
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
});

</script>

{{--Script--}}
<script>

        $(document).ready(function () {
    
            $(document).on("click", "#update_data", function (e) {
                e.preventDefault();
               var url = "{{ URL('/todos/update'.$m->id)}}";
               var id= 
                        $.ajax({
                            url: url,
                            type: "PUT",
                            cache: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                            type: 3,
                                            project_id: $(project_id).val();
                                            todo: $(todo).val();
                                            status_id: $(status).val();
    
                            },
                            success: function(dataResult){
                                dataResult = JSON.parse(dataResult);
                                if(dataResult.statusCode)
                                {
                                    window.location= "/todos";
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
@endsection

