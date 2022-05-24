@extends('layouts.adminTemplate')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<!-- /.content-header -->   

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <div class="mb-3 text-center">
                    <div class="img-container-center">
                        <img style="width: 60% " src="{{ asset('admin/AdminLTE-3.1.0/dist/img/TSM_logo.png') }}" alt="TSM Logo">                    </div>
                  </div>
                  <div class="mb-3 text-center">
                      <h4>Welcome To Professional Services Team Task Management System</h4>
                      <h5>Admin</h5>
                  </div>
                </div>
            </div>

            <div class="card">
              <div class="card-header"> User Details</div>
              
              <div class="card-body">
                <div class="mb-3 Text-left">
                   <h6> Name: {{ Auth::user()->name }}</h6>
                   <h6> Email: {{ Auth::user()->email}}</h6>
                   <h6> Username: {{ Auth::user()->username}}</h6>
                </div>
              </div>
            </div>

            
          </div>
        </div>
    </div>
</div>
@endsection
