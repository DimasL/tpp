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
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('users/create')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- User Info-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div style="display: none;">
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="#" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">

                                <div class="form-group @if($errors->first('name'))has-error @endif">
                                    <label class="control-label" for="nameInput">Name*</label>
                                    <input name="name" type="text" value="@if(old('name')){{old('name')}}@endif" class="form-control" id="nameInput" placeholder="User name">
                                    <span class="help-block">{{$errors->first('name')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('email'))has-error @endif">
                                    <label class="control-label" for="emailInput">Email*</label>
                                    <input name="email" type="text" value="@if(old('email')){{old('email')}}@endif" class="form-control" id="emailInput" placeholder="Email">
                                    <span class="help-block">{{$errors->first('email')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
