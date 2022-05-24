@extends('layouts.adminTemplate')

@section('content')

<div class="content-wrapper">
    
    {{-- Message alert --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif
        </div>
    </div>

    {{-- Edit page body --}}
    <br>
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>Edit User</h2>
        </div>  
    </div>

    {{-- error body --}}
    @if ( count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Edit Form --}}
    <div class="card border-dark mb-3">
        <div class="card-header text-white bg-dark mb-3">Edit User</div>

        {{-- Card body 1--}}
        <div class="card-body">
            {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update',$user->id]]) !!}

            <div class="form-group">

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Name:</strong>
                        {!! Form::text('name', null, array( 'placeholder' => 'Name', 'class' => 'form-control' )) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Username:</strong>
                        {!! Form::text('username', null, array( 'placeholder' => 'Username', 'class' => 'form-control' )) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Email:</strong>
                        {!! Form::text('email', null, array( 'placeholder' => 'Email', 'class' => 'form-control' )) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Password:</strong>
                        {!! Form::password('password', null, array( 'placeholder' => 'Password', 'class' => 'form-control' )) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Confirm Password:</strong>
                        {!! Form::password('confirm-password', null, array( 'placeholder' => 'Confirm Password', 'class' => 'form-control' )) !!}
                    </div>
                </div>
                
                {{--<div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Role:</strong>
                        {!! Form::select('roles[]', $roles, $userRole, array( 'class'=> 'form-control', 'multiple' )) !!}
                    </div>
                </div>--}}

                {{--<div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label"> Role: </strong>
                        {!! Form::select('type[]', $user->type, array( 'class' => 'form-control', 'multple')) !!}
                    </div>
                </div>--}}

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Roles:</strong>
                        {!! Form::checkbox('user', 'type') !!}
                        {!! Form::checkbox('admin', 'type')!!}
                        {!! Form::text('type', null, array( 'placeholder' => 'Type', 'class' => 'form-control' )) !!}
                    </div>
                </div>

                

                <div class="form-group row">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>

            </div>{{--form-group--}}
            {!! Form::close() !!}
        </div>
    </div>
    

</div>
@endsection