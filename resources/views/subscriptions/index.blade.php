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
                                User Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('subscriptions')}}" title="List">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                    @if(in_array('admin', Auth::user()->roles()->lists('slug')->toArray()))
                                        <li>
                                            <a href="{{url('subscriptions/update/' . $Subscription->id)}}" title="Update">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Subscription Info-->
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="product-title">
                                {{$Subscription->title}}
                            </h3>
                            <p>Description: {{$Subscription->description}}</p>
                            <p>Duration(Days): {{$Subscription->duration}}</p>
                            @if(Auth::check())
                                <div class="btn-group pull-right" role="group" style="margin:10px;">
                                    @if(!Auth::user()->subscribed('timeline', $Subscription->id))
                                        <a type="button" href="{{url('mysubscriptions/subscribe/' . $Subscription->id)}}" class="btn btn-default btn-success"><span
                                                    class="fa fa-share-alt"></span> Subscribe
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
