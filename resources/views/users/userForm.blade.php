@extends('layouts.adminTemplate')

@section('content')

<div class="content-wrapper">

    {{-- Form Header--}}
    <br>
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>New User Form</h2>
        </div>
    </div>

    {{--card--}}
    <div class="card border-dark mb-3">
        <div class="card-header text-white bg-dark mb-3">Create New User</div>

        {{-- Card body--}}
        <div class="card-body">

            {!! Form::open(array('route' => 'users.store', 'method' => 'POST')) !!}
            <div class="form-group">

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Full Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name', 'class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Username:</strong>
                        {!! Form::text('username', null, array('placeholder' => 'Username', 'class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Email:</strong>
                        {!! Form::text('email', null, array('placeholder' => 'Email', 'class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Password:</strong>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                        {{--{!! Form::password('password', null, array('placeholder' => 'Password', 'class' => 'form-control')) !!}--}}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label"> Confirm Password:</strong>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required class="form-control">
                        {{--{!! Form::password('confirm-password', null, array('placeholder' => 'Confirm Password')) !!}--}}
                    </div>
                </div>

                {{--<div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Role:</strong>
                        {!! Form::select('roles[]', $roles, [], array( 'class'=> 'form-control', 'multiple' )) !!}
                    </div>
                </div>--}}

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Role Type:</strong>
                        <select name="type[]" id="type" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection