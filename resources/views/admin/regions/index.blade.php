@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    <p><a href="{{ route('admin.regions.create') }}" class="btn btn-success mt-4">Add Region</a></p>
    
    @include('admin.regions._list', ['regions'=> $regions])
@endsection