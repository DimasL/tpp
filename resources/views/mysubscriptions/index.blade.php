@extends('layouts.master')

@section('mysubscriptions_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                My Subscription Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('mysubscriptions')}}" title="List">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- UsersSubscription Info-->
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="product-title">
                                @if($UsersSubscription->subscription)
                                    Title: <a href="{{url('/subscriptions/view/' . $UsersSubscription->subscription->id)}}">{{$UsersSubscription->subscription->title}}</a>
                                @else
                                    {{ucfirst($UsersSubscription->item_type)}} subscribe: <a href="{{url('/' . $UsersSubscription->item_type . '/view/' . $UsersSubscription->item_id)}}">{{$UsersSubscription->getSubscriptionItem()->title}}</a>
                                @endif
                            </h3>
                            @if($UsersSubscription->start)
                            <p>Start: {{$UsersSubscription->start}}</p>
                            <p>Finish: {{$UsersSubscription->finish}}</p>
                            @endif
                            @if(Auth::check())
                                <div class="btn-group pull-right" role="group" style="margin:10px;">
                                    @if(Auth::user()->subscribed('timeline', $UsersSubscription->subscription->id))
                                        <a type="button" href="{{url('subscriptions/unsubscribe/' . $UsersSubscription->id)}}" class="btn btn-default btn-alert"><span
                                                    class="fa fa-minus-circle"></span> Unsubscribe
                                        </a>
                                    @else
                                        <a type="button" href="{{url('subscriptions/subscribe/' . $UsersSubscription->id)}}" class="btn btn-default btn-success"><span
                                                    class="fa fa-share-alt"></span> Subscribe again
                                        </a>
                                        <a type="button" href="{{url('subscriptions/remove/' . $UsersSubscription->id)}}" class="btn btn-default btn-alert"><span
                                                    class="fa fa-minus-circle"></span> Delete
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
