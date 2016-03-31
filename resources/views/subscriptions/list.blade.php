@extends('layouts.master')

@section('subscriptions_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Subscriptions list
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    @if(Auth::user()->isUserCan('create'))
                                        <li>
                                            <a href="{{url('subscriptions/create')}}" title="Add Subscription">
                                                <i class="fa fa-plus"></i> Add
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($Subscriptions->count())
                            <table class="table table-striped">
                                <thead>
                                    <td class="text-center">#</td>
                                    <td class="text-center">Title</td>
                                    <td class="text-center">Duration(Days)</td>
                                    <td class="text-center">Created at</td>
                                    <td class="text-right"></td>
                                </thead>
                                <tbody>
                                    @foreach($Subscriptions as $key => $Subscription)
                                        <tr>
                                            <td class="text-center">{{$key}}</td>
                                            <td class="text-center">{{$Subscription->title}}</td>
                                            <td class="text-center">{{$Subscription->duration}}</td>
                                            <td class="text-center">{{$Subscription->created_at}}</td>
                                            <td class="text-right">
                                                <a href="{{url('subscriptions/view/' . $Subscription->id)}}" title="More info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(Auth::user()->isUserCan('update'))
                                                    <a href="{{url('subscriptions/update/' . $Subscription->id)}}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                @endif
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
