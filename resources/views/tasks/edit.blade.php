@extends('layouts.template')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Task Form</h1>
           </div><!-- /.col -->
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            </ol>
          </div>
          
          <!-- The Form-->
          <div class="card-body">
          <form action="{{ url('/tasks/update/'.$new_tasks->id)}}" method="POST">
            @csrf
            @method('PUT')

            <!-- Drop-down list for project from project table-->
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-12">
              <strong>Project: </strong>
                  <select class="form-control" required name="project_id">
                      <option value="">-- Choose Project --</option>
                      @foreach ($projects as $id => $name)
                          <option
                              value="{{$id}}" {{ (isset($new_tasks['project_id']) && $new_tasks['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                      @endforeach
                  </select>
              </div>
              <br>        
              <br>
            </div>
              <br>
              <!-- end of drop down -->

            <div class="main-form">
             <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Task:</strong>
                        <input type="text" name="task" value="{{$new_tasks->task }}" class="form-control" required placeholder="Task">
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-12">
                  <div class="form-group">
                    <strong>Effort Hours:</strong>
                        <input type="number" name="effort_hours" value="{{$new_tasks->effort_hours }}" class="form-control" required placeholder="Effort Hours">
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-12">
                  <div class="form-group">  
                    <strong>Progress</strong>
                    <select class="form-control" name="progress">
                      <option value="">--Progress--</option>
                      @foreach (range(0,100,10) as $progress)
                          <option value="{{$progress}}" {{$new_tasks->progress == $progress ? 'selected': ''}}>{{$progress}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
             
             <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <button type="submit" name="save_data" class="btn btn-primary">Update</button>
                  <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
                </div>
            </div>

        </form>
        </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<!--Container for form-->
</div>
 
@endsection