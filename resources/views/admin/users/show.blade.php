@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.users.update') }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
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
                @if ($user->status === \App\Entity\User::STATUS_WAIT)
                    <span class="badge badge-secondary">Waiting</span>
                @endif
                @if ($user->status === \App\Entity\User::STATUS_ACTIVE)
                    <span class="badge badge-primary">Active</span>
                @endif
            </td>
        </tr>

        ///////
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>

                <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>


            </tr>
        @endforeach
        /////////

        </tbody>
    </table>

    {{ $users->links() }}

@endsection