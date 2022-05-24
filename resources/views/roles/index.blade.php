@extends('layouts.adminTemplate')

@section('content')

<div class="content-wrapper">

    {{-- Page Header--}}
    <br>
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>Role Management</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a href="{{ route('roles.create')}}" class="btn btn-success">Create New Role</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $roles->firstItem() + $key }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="" class="btn btn-primary">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

</div>
@endsection