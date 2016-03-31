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
                                Users list
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    @if(Auth::user()->isUserCan('create'))
                                        <li>
                                            <a href="{{url('users/create')}}" title="Add User">
                                                <i class="fa fa-plus"></i> Add
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($Users->count())
                            <table class="table table-striped">
                                <thead>
                                    <td class="text-center">#</td>
                                    <td class="text-center">Email</td>
                                    <td class="text-center">Name</td>
                                    <td class="text-center">Role</td>
                                    <td class="text-center">Created at</td>
                                    <td class="text-right"></td>
                                </thead>
                                <tbody>
                                    @foreach($Users as $key => $User)
                                        <tr>
                                            <td class="text-center">{{$key}}</td>
                                            <td class="text-center">{{$User->email}}</td>
                                            <td class="text-center">{{$User->name}}</td>
                                            <td class="text-center">{{$User->roles->first()['title']}}</td>
                                            <td class="text-center">{{$User->created_at}}</td>
                                            <td class="text-right">
                                                <a href="{{url('users/view/' . $User->id)}}" title="More info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(Auth::user()->isUserCan('update'))
                                                    <a href="{{url('users/update/' . $User->id)}}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No users</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
