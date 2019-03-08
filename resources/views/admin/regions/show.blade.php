@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    <div class="d-flex flex-row mb-3">
        <div class="btn-group col-xs-4">
            <a href="{{ route('admin.regions.edit', $region) }}" class="btn btn-primary mr-1 ">Edit</a>

            @if ($user->isWait())
                <form method="POST" action="{{ route('admin.regions.verify', $region) }}" class="mr-1 form col-xs-offset-1">
                    {{ csrf_field() }}
                    <button class="btn btn-success">Verify</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.regions.update', $region) }}" class="mr-1 form col-xs-offset-1">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <td>{{ $region->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $region->name }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $region->slug }}</td>
        </tr>
        </tbody>
    </table>

@endsection