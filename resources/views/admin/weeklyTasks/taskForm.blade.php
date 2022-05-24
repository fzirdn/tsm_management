@extends('layouts.Admintemplate')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif
           
           <br>
           
           <div class="mb-3 text-center">
              <div class="col-lg-12 margin-tb">
                <h2>Weekly Tasks Form</h2>
              </div>
            </div>

            <div class="card border-dark mb-3">
              <div class="card-header text-white bg-dark mb-3">Add New Tasks</div>

              <div class="card-body">
                <form action="{{ route('Admintasks.store') }}" method="POST">
                  @csrf
      
                  <!-- Drop-down list for project from project table-->
                  <div class="main-form"></div>
                  <div class="form-group">

                    <div class="form-group row">
                      <div class="col">
                        <strong class="col-sm-2 col-form-label">Week Number:</strong>
                        <label> <input type="number" name="week_number[]" required class="form-control" value="{{ $week_number }}"></label>
                      </div>
                    </div>

                  <div class="form-group row">
                    <div class="col">
                      <strong class="col-sm-2 col-form-label">Project:</strong>
                      <label><select class="form-control" required name="project_id" style="width: 550px">
                        <option>-----------------------------------Choose Project-----------------------------------</option>
                        @foreach ($projects as $id => $name)
                            <option value="{{$id}}" {{ (isset($new_tasks['project_id']) && $new_tasks['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                        @endforeach
                      </select></label>
                    </div>
                  </div>
                  <!-- end of drop down -->

                  <!--For Task Field-->
                  <div class="form-group row">
                    <div class="col">
                      <strong class="col-sm-2 col-form-label">Tasks: </strong>
                      <label><input type="text" name="task[]" class="form-control" required placeholder="Task" size="70"></label> 
                    </div>
                  </div>
                  <!-- End of Task Field-->

                  <div class="form-group row">
                    <div class="col">
                      <strong class="col-sm-2 col-form-label"> Estimate Effort Hours:</strong>
                      <label for="effort_hours">
                        <input type="number" name="effort_hours[]" class="form-control" required placeholder="Effort hours" style="width: 130px">
                      </label>
                    </div>
                    <div class="col">
                      <strong class="col-sm- col-form-label">Progress: </strong>
                      <label for="effort_hours">
                        <select class="form-control" name="progress[]" style="width: 210px">
                          <option value="">--Progress--</option>
                          @foreach (range(0,100,10) as $progress)
                              <option value="{{$progress}}">{{$progress}}</option>
                          @endforeach
                        </select>
                      </label>
                    </div>
                  </div>
                </div>

                  <div class="text-right">
                    <a href="javascript:void(0)" class="add-more-task btn btn-dark" >Add</a>
                  </div>

                  <div class="paste-new-task"></div>

                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" name="save_data" class="btn btn-secondary">Submit</button>
                    
                    <a class="btn btn-secondary" href="{{ route('Admintasks.index') }}"> Back</a>
                  </div>
                </form>

              </div><!--for div class=main-form-->      
            </div>
       </div>
    </div>
</div>
 <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
 <script>
   $(document).ready(function () {

    $(document).on('click', '.remove-btn', function () {
                $(this).closest('.main-form').remove();
            });

    $(document).on('click', '.add-more-task', function () {
       $('.paste-new-task').append('<div class="main-form"><hr>\
        <div class="form-group">\
                  <div class="form-group row">\
                    <div class="col">\
                      <strong class="col-sm-2 col-form-label">Project:</strong>\
                      <label><select class="form-control" required name="project_id" style="width: 550px">\
                        <option>---Choose Project---</option>\
                        @foreach ($projects as $id => $name)\
                            <option value="{{$id}}" {{ (isset($new_tasks['project_id']) && $new_tasks['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>\
                        @endforeach\
                      </select></label>\
                    </div>\
                  </div>\
                  <div class="form-group row">\
                    <div class="col">\
                      <strong class="col-sm-2 col-form-label">Tasks: </strong>\
                      <label><input type="text" name="task[]" class="form-control" required placeholder="Task" size="70"></label> \
                    </div>\
                  </div>\
                  <div class="form-group row">\
                    <div class="col">\
                      <strong class="col-sm-2 col-form-label"> Estimate Effort Hours:</strong>\
                      <label for="effort_hours">\
                        <input type="number" name="effort_hours[]" class="form-control" required placeholder="Effort hours" style="width: 130px">\
                      </label>\
                    </div>\
                    <div class="col">\
                      <strong class="col-sm-2 col-form-label">Progress: </strong>\
                      <label for="progress">\
                        <select class="form-control" name="progress[]" style="width: 210px">\
                          <option value="">--Progress--</option>\
                          @foreach (range(0,100,10) as $progress)\
                              <option value="{{$progress}}">{{$progress}}</option>\
                          @endforeach\
                        </select>\
                      </label>\
                    </div>\
                  </div>\
                </div>\
                  <div class="text-right">\
                    <a  class="remove-btn btn btn-dark">Remove</a>\
                  </div>\
                  </div>\
                  </div>\
                  </div>\
                  </div>');
    });
   });
 </script>
@endsection