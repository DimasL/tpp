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
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('categories/create')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- Category Info-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div style="display: none;">
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="#" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@endif" class="form-control" id="titleInput" placeholder="Category title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Category description">@if(old('description')){{old('description')}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('parent_category_id'))has-error @endif">
                                    <label class="control-label" for="parent_category_id">Parent category</label>
                                    <select class="form-control" name="parent_category_id" id="parent_category_id">
                                        <option value="">Select Parent Category</option>
                                        @foreach($Categories as $Cat)
                                            <option value="{{$Cat->id}}" @if(old('parent_category_id') == $Cat->id) selected @endif>{{$Cat->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{$errors->first('parent_category_id')}}</span>
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
