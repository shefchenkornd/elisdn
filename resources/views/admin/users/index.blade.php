@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <p class="mt-10">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Add User</a>
    </p>

    <div class="card mb-3">
        <div class="card-header">Filter</div>
        <div class="card-body">
            <form action="?" method="GET">
                <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="id" class="col-form-label">ID</label>
                            <input name="id" id="id" type="text" class="form-control" value="{{ request('id') }}">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input name="name" id="name" type="text" class="form-control" value="{{ request('name') }}">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input name="email" id="email" type="text" class="form-control" value="{{ request('email') }}">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="status" class="col-form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}"  {{ $value === request('status') ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="role" class="col-form-label">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value=""></option>
                                @foreach($roles as $value => $label)
                                    <option value="{{ $value }}"  {{ $value === request('role') ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-info">search</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
            <td>{{ $user->email }}</td>
            <td>
                @if ($user->isWait())
                    <span class="badge badge-secondary">Waiting</span>
                @endif
                @if ($user->isActive())
                    <span class="badge badge-primary label-info">Active</span>
                @endif
            </td>
            <td>
                @if ($user->isAdmin())
                    <span class="badge badge-danger label-danger">Admin</span>
                @else
                    <span class="badge badge-secondary">User</span>
                @endif
            </td>
        </tr>
        @endforeach
        
        </tbody>
    </table>

@endsection