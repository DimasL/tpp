@extends('layouts.master')

@section('products_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                Search Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right"></div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Product Info-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <form class="navbar-form" role="search" action="{{url('search')}}">
                                    <h2>Search</h2>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" value="{{$srch}}"
                                               name="srch" id="srch">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
                                                        class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                @if($Products->count() == 0 && $Categories->count() == 0)
                                    <p>No results</p>
                                @else
                                    <h3>Results:</h3>
                                    <ul>
                                        @foreach($Products as $Product)
                                            <li>
                                                <a href="{{$Product->getUrl()}}">{{$Product->title}}</a>
                                                <p>{{substr($Product->description, 0, 10)}}@if(strlen($Product->description) > 10)...@endif</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <ul>
                                        @foreach($Categories as $Category)
                                            <li>
                                                <a href="{{$Category->getUrl()}}">{{$Category->title}}</a>
                                                <p>{{substr($Category->description, 0, 10)}}@if(strlen($Category->description) > 10)...@endif</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
