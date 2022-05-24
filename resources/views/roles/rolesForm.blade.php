@extends('layouts.adminTemplate')

@section('content')

<div class="content-wrapper">

    {{-- Form Header--}}
    <br>
    <div class="mb-3 text-center">
        <div class="col-lg-12 margin-tb">
            <h2>New Role Form</h2>
        </div>
    </div>

    {{--card--}}
    <div class="card border-dark mb-3">
        <div class="card-header text-white bg-dark mb-3">Create New Role</div>

        {{-- Card body--}}
        <div class="card-body">

            {!! Form::open(array('route' => 'roles.store', 'method' => 'POST')) !!}
            <div class="form-group">

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name', 'class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <strong class="col-sm-2 col-form-label">Permission:</strong>
                        <br>
                        @foreach ($permission as $value)
                            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                            {{ $value->name }}</label>                            
                        @endforeach
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