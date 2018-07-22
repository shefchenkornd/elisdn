@extends('layouts.app')

@section('breadcrums')
    <ul class="breadcrums">
        <li class="breadcrums-item"><a href="{{ route('home')  }}">Home</a></li>
        <li class="breadcrums-item active">Login</li>
    </ul>
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection