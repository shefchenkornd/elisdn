@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="d-flex flex-row mb-3">
        <div class="btn-group col-xs-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-1 ">Edit</a>

            @if ($user->isWait())
                <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="mr-1 form col-xs-offset-1">
                    {{ csrf_field() }}
                    <button class="btn btn-success">Verify</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mr-1 form col-xs-offset-1">
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
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($user->isWait())
                    <span class="badge badge-secondary">Waiting</span>
                @endif
                @if ($user->isActive())
                    <span class="badge badge-primary">Active</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Role</th>
            <td>
                @if ($user->isAdmin())
                    <span class="badge badge-primary">Admin</span>
                @else
                    <span class="badge badge-secondary">User</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

@endsection