@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <form method="POST" action="{{ route('admin.users.store') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input name="name" value="{{ old('name') }}" type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} required">
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="name" class="col-form-label">E-mail Address</label>
            <input name="email" value="{{ old('name') }}" type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} required">
            @if ($errors->has('email'))
                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>

@endsection