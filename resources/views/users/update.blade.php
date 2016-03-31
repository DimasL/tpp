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
                                    <li>
                                        <a href="{{url('users/view/' . $User->id)}}" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('users/update/' . $User->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- User Info-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div @if(!$User->image)style="display: none!important;" @endif>
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="@if($User->image){{asset('assets/images/users/' . $User->image)}}@else#@endif" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">

                                <div class="form-group @if($errors->first('name'))has-error @endif">
                                    <label class="control-label" for="nameInput">Name*</label>
                                    <input name="name" type="text" value="@if(old('name')){{old('name')}}@else{{$User->name}}@endif" class="form-control" id="nameInput" placeholder="User name">
                                    <span class="help-block">{{$errors->first('name')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('email'))has-error @endif">
                                    <label class="control-label" for="emailInput">Email*</label>
                                    <input name="email" type="text" value="@if(old('email')){{old('email')}}@else{{$User->email}}@endif" class="form-control" id="emailInput" placeholder="Email">
                                    <span class="help-block">{{$errors->first('email')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('roles'))has-error @endif">
                                    <label class="control-label" for="emailInput">Role*</label>
                                    <select class="form-control" name="role">
                                        @foreach($Roles as $role)
                                            <option @if($role->id == $User->roles->first()->id) selected @endif value="{{$role->id}}">{{$role->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{$errors->first('roles')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Update</button>
                                    <button type="button" class="btn btn-default btn-danger delete-user" data-toggle="modal" data-target="#deleteUserModal" data-id="{{$User->id}}" data-name="{{$User->name}}" data-email="{{$User->email}}">
                                        <span class="fa fa-close"></span> Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Delete user</h4>
                </div>
                <div class="modal-body">
                    <div class="deleteMessage"></div>
                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post" action="{{url('users/delete/' . $User->id)}}">
                        {{csrf_field()}}
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
