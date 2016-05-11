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
                                <a href="#" class="btn btn-default btn-success buy-now-button"><span
                                            class="fa fa-plus"></span> Buy Now
                                </a>
                                <!--<button type="button" class="btn btn-default btn-info"><span
                                            class="fa fa-shopping-cart"></span> Checkout
                                </button>-->
                            </div>
                        </div>
                        <div class="row buy-now-section" style="display: none">
                            <form action="{{ url('products/buy') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $Product->id }}">
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->first('card_number'))has-error @endif">
                                        <label class="control-label" for="titleInput">Card number*</label>
                                        <input name="card_number" type="text" value="4007000000027" class="form-control" autocomplete="off" required>
                                        <span class="help-block">{{$errors->first('card_number')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->first('cvv'))has-error @endif">
                                        <label class="control-label" for="titleInput">CVV*</label>
                                        <input name="cvv" type="password" value="" class="form-control" autocomplete="off" required>
                                        <span class="help-block">{{$errors->first('cvv')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->first('card_number'))has-error @endif">
                                        <label class="control-label" for="titleInput">Exp Month*</label>
                                        <select class="form-control" name="exp_month" autocomplete="off" required>
                                            <option value="">Select a month</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value="{{ date('n', mktime(0, 0, 0, $i, 10)) }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                            @endfor
                                        </select>
                                        <span class="help-block">{{$errors->first('card_number')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="titleInput">Exp Year*</label>
                                    <select name="exp_year" class="form-control" autocomplete="off" required>
                                        <option class="title" value="">Year</option>
                                        @for ($i = 0; $i < 15; $i++)
                                            <option value="{{ date("Y") + $i }}">{{ date("Y") + $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success float-right">Purchase</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
