@extends('layouts.app')

@section('content')
    @include('admin.users._nav')


    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

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
            <label for="status" class="col-form-label">Status</label>
            <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                @foreach($statuses as $value => $label)
                <option value="{{ $value }}" {{ $value === old('status', $user->status ? ' selected' : '' ) }}>{{ $value }}</option>
            </select>
            @if ($errors->has('status'))
                <span class="invalid-feedback"><strong>{{ $errors->first('status') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection