@extends('layouts.master')

@section('subscriptions_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                Subscription Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('subscriptions')}}" title="List">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('subscriptions/create')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <!-- Subscription Info-->
                            <div class="col-xs-12 col-sm-12">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@endif" class="form-control" id="titleInput" placeholder="Subscription title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('duration'))has-error @endif">
                                    <label class="control-label" for="durationInput">Duration(Days)*</label>
                                    <input name="duration" min="0" type="number" value="@if(old('duration')){{old('duration')}}@endif" class="form-control" id="durationInput" placeholder="Duration">
                                    <span class="help-block">{{$errors->first('duration')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Subscription description">@if(old('description')){{old('description')}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
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
