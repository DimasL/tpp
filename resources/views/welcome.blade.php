@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <h3>Home page.</h3>
                    @if(!Auth::check())
                        <p>Please <a href="{{url('login')}}">login</a> or <a href="{{url('register')}}">register</a> a new account.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
