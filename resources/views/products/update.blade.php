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
                                    <li>
                                        <a href="{{url('products/view/' . $Product->id)}}" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('products/update/' . $Product->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- Product Info-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div @if(!$Product->image)style="display: none!important;" @endif>
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="@if($Product->image){{asset('assets/images/products/' . $Product->image)}}@else#@endif" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@else{{$Product->title}}@endif" class="form-control" id="titleInput" placeholder="Product title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('category_id'))has-error @endif">
                                    <label class="control-label" for="emailInput">Category</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">No category</option>
                                        @foreach($Categories as $category)
                                            <option @if($category->id == $Product->category_id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{$errors->first('category_id')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('sku'))has-error @endif">
                                    <label class="control-label" for="skuInput">Sku*</label>
                                    <input name="sku" type="text" value="@if(old('sku')){{old('sku')}}@else{{$Product->sku}}@endif" class="form-control" id="skuInput" placeholder="Sku">
                                    <span class="help-block">{{$errors->first('sku')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('price'))has-error @endif">
                                    <label class="control-label" for="priceInput">Price*</label>
                                    <input name="price" type="number" step="any" min="1" value="@if(old('price')){{old('price')}}@else{{$Product->price}}@endif" class="form-control" id="priceInput" placeholder="Price">
                                    <span class="help-block">{{$errors->first('price')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Product description">@if(old('description')){{old('description')}}@else{{$Product->description}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Update</button>
                                    <button type="button" class="btn btn-default btn-danger delete-product" data-toggle="modal" data-target="#deleteProductModal" data-id="{{$Product->id}}" data-title="{{$Product->title}}" data-sku="{{$Product->sku}}">
                                        <span class="fa fa-close"></span> Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Delete product</h4>
                </div>
                <div class="modal-body">
                    <div class="deleteMessage"></div>
                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post" action="{{url('products/delete/' . $Product->id)}}">
                        {{csrf_field()}}
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
