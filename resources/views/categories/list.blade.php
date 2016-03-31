@extends('layouts.master')

@section('categories_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                Categories list
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    @if(Auth::user()->isUserCan('create'))
                                        <li>
                                            <a href="{{url('categories/create')}}" title="Add Category">
                                                <i class="fa fa-plus"></i> Add
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="categories-list-main">
                            @foreach ($Categories as $Category)
                                @include('categories.template')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
