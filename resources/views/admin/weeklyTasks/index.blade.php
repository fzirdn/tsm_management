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
            <h2>Weekly Task List</h2>
        </div>
    </div>

    <br>

    {{--Search for employee's--}}
    <div class="row justify-content-center">
            {{-- Search for staff --}}
           <div class="col-md-4">
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
            <div class="col-md-4">
                <form action="{{ route('Admintasks.searchweek') }}">
                    <div class="input-group mb-5">
                        <input type="number" class="form-control" value="{{ request('searchWeek')}}" placeholder="Week Number">
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
              <a class="btn btn-success" href="{{ route('Admintasks.create') }}"> Add New Tasks</a>
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
                        <th> Progress </th>
                        <th width="120px"> Estimate Effort Hours </th>
                        <th width="120px"> Created At </th>
                    @else
                        <th> No </th>
                        <th> Project </th>
                        <th> Task </th>
                        <th> Progress </th>
                        <th width="120px"> Estimate Effort Hours </th>
                        <th width="120px"> Created At </th>
                        <th width="190px"> Action </th>
                    @endif
                </tr>
                @foreach ($new_task as $key => $item)
                <tr>
                    @if (request()->has('search'))
                        <td> {{ $new_task->firstItem() + $key }} </td>
                        <td> {{ $item->user->name}} </td>
                        <td> {{ $item->projects->name}} </td>
                        <td> {{ $item->task}} </td>
                        <td> 
                            @if (($item->progress) == '100')
                                <p style="color:green">{{ $item->progress }}</p>
                            @else
                                <p>{{ $item->progress }}</p>
                            @endif
                        </td>
                        <td> {{ $item->effort_hours }} </td>
                        <td> {{ $item->created_at->format('j F Y g:i A') }} </td>
                    @else
                        <td> {{ $new_task->firstItem() + $key }} </td>
                        <td> {{ $item->projects->name}} </td>
                        <td> {{ $item->task}} </td>
                        <td> 
                            @if (($item->progress) == '100')
                                <p style="color:green">{{ $item->progress }}</p>
                            @else
                                <p>{{ $item->progress }}</p>
                            @endif
                        </td>
                        <td> {{ $item->effort_hours }} </td>
                        <td> {{ $item->created_at->format('j F Y g:i A') }} </td>
                        <td> 
                            @if (($item->progress) == '100')
                                <a style="color:green">Good Job!</a>
                            @else
                                <label><a href="javascript:void(0)" id="show-task" data-url="{{ route('Admintasks.edit', $item->id)}}" class="btn btn-primary">Edit</a></label>
                                <label><form class="delete" method="POST" action="{{ route('Admintasks.destroy', $item->id) }}">
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

{{-- For Modal --}}
@foreach ($new_task as $item)
@if($item != '')
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/admin/tasks/update/'.$item->id)}}" method="POST" id="editForm_{{$item->id}}">
                @csrf
                @method('PUT')

                <input type="hidden" id="id" name="id" value="{{$item->id}}">
                <div class="row">
                    <label for="">Project:</label>
                    <select required name="project_id" class="form-control" id="project_id">
                        <option value="">--Choose Project--</option>
                        @foreach ($projects as $id => $name)
                        <option 
                            value="{{$id}}" {{ (isset($new_task['project_id']) && $new_task['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <label for="">Task:</label>
                    <input type="text" id="task" name="task" value="{{$item->todo }}" class="form-control" required placeholder="Task">
                </div>

                <div class="row">
                    <label for="">Progress:</label>
                    <select class="form-control" name="progress" id="progress">
                        <option value="">--Progress--</option>
                        @foreach (range(0,100,10) as $progress)
                            <option value="{{$progress}}" {{$item->progress == $progress ? 'selected': ''}}>{{$progress}}</option>
                        @endforeach
                      </select>
                </div>

                <div class="row">
                    <label for="">Effort Hours:</label>
                    <input type="number" id="effort_hours" name="effort_hours" value="{{$item->effort_hours }}" class="form-control" required placeholder="Effort Hours">
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

{{--Script--}}
<script type="text/javascript">

//For modal 
$(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#show-task', function () {
          var taskURL = $(this).data('url');
          $.get(taskURL, function (data) {
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
                                window.location= "/admin/tasks";
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