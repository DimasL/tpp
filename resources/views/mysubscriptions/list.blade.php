@extends('layouts.master')

@section('mysubscriptions_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                My Subscriptions list
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 text-right">
                                <!--<ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('subscriptions')}}" title="Subscriptions list">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </li>
                                </ul>-->
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($UsersSubscriptions->count())
                            <table class="table table-striped">
                                <thead>
                                    <td class="text-center">#</td>
                                    <td class="text-center">Type</td>
                                    <td class="text-center">Start</td>
                                    <td class="text-center">Finish</td>
                                    <td class="text-center">Status</td>
                                    <td class="text-center">Created at</td>
                                    <td class="text-right"></td>
                                </thead>
                                <tbody>
                                    @foreach($UsersSubscriptions as $key => $Subscription)
                                        <tr>
                                            <td class="text-center">{{$key}}</td>
                                            <td class="text-center">{{$Subscription->item_type}}</td>
                                            <td class="text-center">{{$Subscription->start}}</td>
                                            <td class="text-center">{{$Subscription->finish}}</td>
                                            <td class="text-center">{{$Subscription->status()}}</td>
                                            <td class="text-center">{{$Subscription->created_at}}</td>
                                            <td class="text-right">
                                                <a href="{{url('mysubscriptions/view/' . $Subscription->id)}}" title="More info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No subscriptions.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
