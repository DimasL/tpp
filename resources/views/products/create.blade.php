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
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('products/create')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- Product Info-->
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div style="display: none;">
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="#" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@endif" class="form-control" id="titleInput" placeholder="Product title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('category_id'))has-error @endif">
                                    <label class="control-label" for="emailInput">Category</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">No category</option>
                                        @foreach($Categories as $category)
                                            <option @if(old('category_id') == $category->id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{$errors->first('category_id')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('sku'))has-error @endif">
                                    <label class="control-label" for="skuInput">Sku*</label>
                                    <input name="sku" type="text" value="@if(old('sku')){{old('sku')}}@endif" class="form-control" id="skuInput" placeholder="Sku">
                                    <span class="help-block">{{$errors->first('sku')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('price'))has-error @endif">
                                    <label class="control-label" for="priceInput">Price*</label>
                                    <input name="price" type="number" step="any" min="0" value="@if(old('price')){{old('price')}}@endif" class="form-control" id="priceInput" placeholder="Price">
                                    <span class="help-block">{{$errors->first('price')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('quantity'))has-error @endif">
                                    <label class="control-label" for="quantity">Quantity</label>
                                    <input name="price" type="number" step="any" value="@if(old('price')){{old('price')}}@endif" class="form-control" id="priceInput" placeholder="Price">
                                    <span class="help-block">{{$errors->first('quantity')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description">@if(old('description')){{old('description')}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
