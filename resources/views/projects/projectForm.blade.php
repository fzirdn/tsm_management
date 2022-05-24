@extends('layouts.template')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project Form</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                    </ol>
                </div>

                <!--Project Form-->
                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <br>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Project Name:</strong>
                                <input type="text" name="name" class="form-control" required placeholder="Project Name">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Project Logo:</strong>
                                <input type="file" name="logo" class="form-control" required placeholder="Project Logos">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Project Description</strong>
                                <input type="text" name="description" class="form-control" required placeholder="Project Description">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" name="save" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection