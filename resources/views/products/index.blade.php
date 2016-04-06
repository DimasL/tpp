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
                                Product Page
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    <li>
                                        <a href="{{url('products')}}" title="List">
                                            <i class="fa fa-list"></i>
                                        </a>
                                    </li>
                                    @if(Auth::check() && in_array('admin', Auth::user()->roles()->lists('slug')->toArray()))
                                        <li>
                                            <a href="{{url('products/update/' . $Product->id)}}" title="Update">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Product Info-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <img src="{{$Product->getImage()}}"
                                     class="img-responsive product-image-large">
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <h3 id="product-title">
                                    {{$Product->title}}
                                </h3>
                                @if($Product->category)
                                    <p><b>Category</b>: <a href="{{$Product->category->getUrl()}}">{{$Product->category->title}}</a></p>
                                @endif
                                <p><b>SKU</b>: {{$Product->sku}}</p>

                                <p><b>Price</b>: ${{$Product->price}}</p>

                                <p><b>Description</b>: {{$Product->description}}</p>

                                <p><b>Quantity</b>: {{$Product->quantity}}</p>
                            </div>
                        </div>
                        <div class="row top-buffer">
                            <div class="col-md-6 col-sm-6">
                                <p class="text-muted">Viewed: {{ $Product->getViewed() }}</p>
                            </div>
                            <div class="btn-group pull-right" role="group" style="margin:10px;">
                                @if(Auth::check() && Auth::user()->isSubscribed('products', $Product->id))
                                    <a href="{{ url('products/unsubscribe/' . $Product->id) }}" class="btn btn-default btn-alert"><span
                                                class="fa fa-minus-circle"></span> Unsubscribe
                                    </a>
                                @elseif(Auth::check())
                                    <a href="{{ url('products/subscribe/' . $Product->id) }}" class="btn btn-default btn-success"><span
                                                class="fa fa-share-alt"></span> Subscribe
                                    </a>
                                @endif
                                <!--<button type="button" class="btn btn-default btn-success"><span
                                            class="fa fa-plus"></span> Add to Cart
                                </button>
                                <button type="button" class="btn btn-default btn-info"><span
                                            class="fa fa-shopping-cart"></span> Checkout
                                </button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
