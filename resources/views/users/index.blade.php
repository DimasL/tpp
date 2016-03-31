@extends('layouts.master')

@section('users_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                User Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('users')}}" title="List">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                    @if(in_array('admin', Auth::user()->roles()->lists('slug')->toArray()))
                                        <li>
                                            <a href="{{url('users/update/' . $User->id)}}" title="Update">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- User Info-->
                        <div class="col-xs-12 col-sm-6">
                            <img @if(!$User->image)style="display: none!important;" @endif src="{{asset('assets/images/users/' . $User->image)}}" class="img-responsive img-thumbnail product-image-large">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h3 id="product-title">
                                {{$User->name}}
                            </h3>
                            <p><b>Email</b>: {{$User->email}}</p>
                            <p><b>User role</b>: {{$User->roles->first()['title']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
