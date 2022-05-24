@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <!--<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                    </ol>
                </div>-->

                <br>

                <div class="mb-3 text-center">
                    <div class="col-lg-12 margin-tb">
                        <h2>Project List</h2>
                    </div>
                </div>

                

                <br>

                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                          <a class="btn btn-success" href="{{ route('projects.create') }}"> Add New Tasks</a>
                      </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Project Name</th>
                        <th>Project Logo</th>
                        <th>Project Description</th>
                        <th>Created At</th>
                        <th width="180px">Action</th>
                    </tr>

                    @foreach ($project as $p)
                    <tr>
                        <td>{{ $p->id}}</td>
                        <td>{{ $p->name}}</td>
                        <td><img src="{{ url('/image'.$p->logo)}}" width="60px" height="60px" alt="logo"></td>
                        <td>{{ $p->description}}</td>
                        <td>{{ $p->created_at}}</td>
                        <td>
                            <a href="{{ route('projects.edit', $p->id)}}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('projects.destroy', $p->id)}}" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>
@endsection