@extends('layouts.master')

@section('logs_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                Logs list
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <button class="delete-logs" data-toggle="modal" data-target="#deleteLogsModal" title="Delete all">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($Logs->count())
                            <table class="table table-striped">
                                <thead>
                                    <td class="text-center">#</td>
                                    <td class="text-center">User</td>
                                    <td class="text-center">Type</td>
                                    <td class="text-center">Status</td>
                                    <td class="text-center">Text</td>
                                    <td class="text-center">Created at</td>
                                </thead>
                                <tbody>
                                    @foreach($Logs as $key => $Log)
                                        <tr>
                                            <td class="text-center">{{$Log->id}}</td>
                                            <td class="text-center">
                                                @if($Log->user)
                                                <a href="{{url('users/view/' . $Log->user_id)}}">{{$Log->user->name}}</a>
                                                @else
                                                    User deleted
                                                @endif
                                            </td>
                                            <td class="text-center">{{$Log->type}}</td>
                                            <td class="text-center">{{$Log->status}}</td>
                                            <td class="text-center">{{$Log->text}}</td>
                                            <td class="text-center">{{$Log->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {!! $Logs->render() !!}
                            </div>
                        @else
                            No logs.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteLogsModal" tabindex="-1" role="dialog" aria-labelledby="deleteLogsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Delete Logs</h4>
                </div>
                <div class="modal-body">
                    <div class="deleteMessage"></div>
                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post" action="{{url('logs/deleteAll')}}">
                        {{csrf_field()}}
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
