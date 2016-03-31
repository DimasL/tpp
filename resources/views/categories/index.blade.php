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
                                Category Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('categories')}}" title="List">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                    @if(in_array('admin', Auth::user()->roles()->lists('slug')->toArray()))
                                        <li>
                                            <a href="{{url('categories/update/' . $Category->id)}}" title="Update">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Category Info-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <img @if(!$Category->image)style="display: none!important;"
                                     @endif src="{{asset('assets/images/categories/' . $Category->image)}}"
                                     class="img-responsive product-image-large">
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <h3 id="product-title">
                                    {{$Category->title}}
                                </h3>
                                <p><b>Description</b>: {{$Category->description}}</p>
                            </div>
                        </div>
                        <div class="row top-buffer">
                            <div class="col-md-6 col-sm-6">
                                <p class="text-muted">Products count: {{ $Category->getProductsCount() }}</p>
                            </div>
                            <div class="btn-group pull-right" role="group" style="margin:10px;">
                                @if(Auth::user()->subscribed('categories', $Category->id))
                                    <a href="{{ url('categories/unsubscribe/' . $Category->id) }}" class="btn btn-default btn-alert"><span
                                                class="fa fa-minus-circle"></span> Unsubscribe
                                    </a>
                                @else
                                    <a href="{{ url('categories/subscribe/' . $Category->id) }}" class="btn btn-default btn-success"><span
                                                class="fa fa-share-alt"></span> Subscribe
                                    </a>
                                @endif
                                <a href="{{ url('products/category/' . $Category->id) }}" class="btn btn-default btn-info"><span
                                            class="fa fa-search"></span> Show Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
