@extends('layouts.template')

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
        @if (\Session::has('error'))
            <div class="alert alert-success" role="alert">
                {{!! \Session::get('error') !!}}
            </div>
        @endif
    </div>

    <!-- Top Header-->
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>Weekly Task List</h2>
        </div>
    </div>



    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{route('tasks.search')}}">
                <div class="input-group mb-3">
                    <!--<input type="text" class="form-control" placeholder="Search..." name="search">-->
                    <select name="search" class="form-control" value="{{request('search')}}">
                        <option>--Search Projects--</option>
                        @foreach ($projects as $id => $name)
                            <option value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    

    <br>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <a class="btn btn-success" href="{{ route('tasks.create') }}"> Add New Tasks</a>
          </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="text-right">

                @if(request()->has('view_completed'))

                    <a href="{{ route('tasks.index') }}" class="btn btn-info btn-sm">View All Task</a>

                @else

                    <a href="{{ route('tasks.showcompleted', ['view_completed']) }}" class="btn btn-primary btn-sm">View Completed Tasks</a>
                    
                @endif

                {{--View Deleted--}}

                @if(request()->has('view_deleted'))
                
                    <a href="{{ route('tasks.index') }}" class="btn btn-info btn-sm">View All Task</a>
                @else

                    <a href="{{ route('tasks.showDeleted', ['view_deleted']) }}" class="btn btn-primary btn-sm">View Deleted Tasks</a>

                @endif

            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Progress</th>
                    <th width="120px"> Estimate Effort Hours</th>
                    <th width="120px">Created At</th>
                    <th width="190px">Action</th>
                </tr>
                @foreach ($new_task as $key => $t)

                <tr>
                    <td>{{ $new_task->firstItem() + $key }}</td>
                    <td>{{ $t->projects->name}}</td>
                    <td>{{ $t->task}}</td>
                    <td>
                            @if (($t->progress) == '100')
                                 <a style="color:green">{{ $t->progress}}</a>  
                            @else
                                <a>{{ $t->progress}}</a>                    
                            @endif
                    </td>
                    <td>{{$t->effort_hours}}</td>
                    <td>{{$t->created_at->format('j F Y g:i A')}}</td>
                    <td>
                        @if (($t->progress) == '100')
                            <a style="color:green">Good Job!</a>
                        @else
                            <label><a href="javascript:void(0)" id="show-task" data-url="{{ route('tasks.edit', $t->id)}}" class="btn btn-primary">Edit</a></label>
                            <label><form class="delete" method="POST" action="{{ route('tasks.destroy', $t->id) }}">
                                @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn btn-danger show_confirm">Delete</button>                                           
                            </form></label>
                        @endif
    
                    </td>
                
                </tr>
                @endforeach
            </table>
        
            <div class="d-flex justify-content-center">
                {{$new_task->links()}}
            </div>
        </div>
    </div>
   
    
  </div>

{{--Modal For Update Progress and Effort Hours--}}
@foreach( $new_task as $t)
@if($t != '')
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/tasks/update/'.$t->id)}}" method="POST" id="editForm_{{$t->id}}">
                @csrf
                @method('PUT')

                <input type="hidden" id="id" name="id" value="{{$t->id}}">
                <div class="row">
                    <label for="">Project:</label>
                    <select class="form-control" required name="project_id" id="project_id">
                        <option value="">-- Choose Project --</option>
                        @foreach ($projects as $id => $name)
                            <option
                                value="{{$id}}" {{ (isset($t['project_id']) && $t['project_id'] == $id) ? ' selected' : '' }} id="project_id">{{$name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <label for="">Task:</label>
                    <input type="text" id="task" name="task" value="{{$t->task }}" class="form-control" required placeholder="Task">
                </div>

                <div class="row">
                    <label for="">Progress:</label>
                    <select class="form-control" name="progress" id="progress">
                        <option value="">--Progress--</option>
                        @foreach (range(0,100,10) as $progress)
                            <option value="{{$progress}}" {{$t->progress == $progress ? 'selected': ''}}>{{$progress}}</option>
                        @endforeach
                      </select>
                </div>
    
                <div class="row">
                    <label for="">Effort Hours:</label>
                    <input type="number" id="effort_hours" name="effort_hours" value="{{$t->effort_hours }}" class="form-control" required placeholder="Effort Hours">
                </div>
            
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update_data">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
      </div>
    </div>
</div>
@endif
@endforeach
{{--Script--}}
<script type="text/javascript">

//For modal 
$(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#show-task', function () {
          var todosURL = $(this).data('url');
          $.get(todosURL, function (data) {
              $('#taskModal').modal('show');
              $('#id').val(data.id);
              $('#project_id').val(data.project_id);
              $('#task').val(data.task);
              $('#progress').val(data.progress);
              $('#effort_hours').val(data.effort_hours);
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
                                        task: $(task).val();
                                        progress: $(progress).val();
                                        effort_hours: $(effort_hours).val();

                        },
                        success: function(dataResult){
                            dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode)
                            {
                                window.location= "/tasks";
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

{{--For delete function--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var todo = $(this).data("todo");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this Task?`,
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

        $.ajax({
            url:"{{ route('todos.deleteSelected')}}",
            type:"DELETE",
            data:{
                _token:$("input[name=_token]").val(),
                ids:allids
            },
            success:function(response){
                $.each(allids, function(key, val){
                    $("#tid"+val).remove();
                })
            }
        });
    })
});
@endsection