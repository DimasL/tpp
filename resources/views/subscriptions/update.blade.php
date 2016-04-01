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
                                            <i class="fa fa-list"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('subscriptions/view/' . $Subscription->id)}}" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('subscriptions/update/' . $Subscription->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- Subscription Info-->
                            <div class="col-xs-12 col-sm-12">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@else{{$Subscription->title}}@endif" class="form-control" id="titleInput" placeholder="Subscription title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('duration'))has-error @endif">
                                    <label class="control-label" for="durationInput">Duration(Days)*</label>
                                    <input name="duration" min="0" type="number" value="@if(old('duration')){{old('duration')}}@else{{$Subscription->duration}}@endif" class="form-control" id="durationInput" placeholder="Duration">
                                    <span class="help-block">{{$errors->first('duration')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Subscription description">@if(old('description')){{old('description')}}@else{{$Subscription->description}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Update</button>
                                    <button type="button" class="btn btn-default btn-danger delete-subscription" data-toggle="modal" data-target="#deleteSubscriptionModal" data-id="{{$Subscription->id}}" data-title="{{$Subscription->title}}">
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

    <div class="modal fade" id="deleteSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="deleteSubscriptionModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Delete subscription</h4>
                </div>
                <div class="modal-body">
                    <div class="deleteMessage"></div>
                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post" action="{{url('subscriptions/delete/' . $Subscription->id)}}">
                        {{csrf_field()}}
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
