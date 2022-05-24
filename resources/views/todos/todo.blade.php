@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif

            <!-- Header-->
            <br> 
            <div class="mb-3 text-center">
                <div class="col-lg-12 margin-tb">
                    <h2>Next Week Tasks</h2>
                </div>
            </div>

            <!--First Box For Create New Task -->
            <div class="card border-dark mb-3">
                <div class="card-header text-white bg-dark mb-3">Add New Tasks</div>

                <div class="card-body">
                    <form action="{{route('todos.store')}}" method="POST">
                        @csrf

                        <div class="main-form"></div>
                        <div class="form-group">
                            <div class="form-group row">
                                <div class="col">
                                    <strong class="col-sm-2 col-form-label">Project: </strong>
                                    <label><select required name="project_id[]" class="form-control" style="width: 220px">
                                        <option>--Choose Project--</option>
                                        @foreach ($projects as $id => $name)
                                        <option 
                                            value="{{$id}}" {{ (isset($todos['project_id']) && $todos['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                                        @endforeach
                                    </select></label>
                                </div>
                                <div class="col">
                                    <strong class="col-sm-2 col-form-label">Status: </strong>
                                    <label for="status">
                                        <select required name="status_id[]" class="form-control" style="width: 220px">
                                            <option value="">--Choose Status--</option>
                                            @foreach ($statuses as $id => $name)
                                            <option 
                                                value="{{$id}}" {{ (isset($statuses['status_id']) && $statuses['status_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <strong class="col-sm-2 col-form-label">Task: </strong>
                                <label class="col-sm-10"><input type="text" name="todo[]" class="form-control" required placeholder="Task" maxlength="255"></label>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" class="add-more-task btn btn-secondary">Add</a>
                            </div>
                        </div>
                        <div class="paste-new-task"></div>
                    </div>
                        <button type="submit" name="save_data" class="btn btn-secondary float-right">Submit</button>
                    </div>
                    </form>
                </div>
                <!-- End For Create New To do List-->    
        </div>
    </div>       
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
    
        $(document).on('click', '.remove-btn', function () {
            $(this).closest('.main-form').remove();
        });

        $(document).on('click', '.add-more-task', function () {
            $('.paste-new-task').append('<div class="main-form">\
                        <div class="form-group">\
                            <hr>\
                            <div class="form-group row">\
                                <div class="col">\
                                    <strong class="col-sm-2 col-form-label">Project: </strong>\
                                    <label><select required name="project_id[]" class="form-control" style="width: 220px">\
                                        <option>--Choose Project--</option>\
                                        @foreach ($projects as $id => $name)\
                                        <option \
                                            value="{{$id}}" {{ (isset($todos['project_id']) && $todos['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>\
                                        @endforeach\
                                    </select></label>\
                                </div>\
                                <div class="col">\
                                    <strong class="col-sm-2 col-form-label">Status: </strong>\
                                    <label for="status">\
                                        <select required name="status_id[]" class="form-control" style="width: 220px">\
                                            <option value="">--Choose Status--</option>\
                                            @foreach ($statuses as $id => $name)\
                                            <option \
                                                value="{{$id}}" {{ (isset($statuses['status_id']) && $statuses['status_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>\
                                            @endforeach\
                                        </select>\
                                    </label>\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <div class="col">\
                                    <strong class="col-sm-2 col-form-label">Task: </strong>\
                                <label class="col-sm-10"><input type="text" name="todo[]" class="form-control" required placeholder="Task" maxlength="255"></label>\
                                </div>\
                            </div>\
                            <div class="text-right">\
                                <a class="remove-btn btn btn-secondary">remove</a>\
                            </div>\
                        </div>\
                        </div>')
        
    
        });
   });

</script>
@endsection