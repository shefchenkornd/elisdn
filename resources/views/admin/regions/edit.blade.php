@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    <form method="POST" action="{{ route('admin.regions.update', $region) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input name="name" value="{{ $region->name }}" type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} required">
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="name" class="col-form-label">Slug</label>
            <input name="slug" value="{{ $region->slug }}" type="slug" id="slug" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }} required">
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection