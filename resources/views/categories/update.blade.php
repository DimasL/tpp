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
                                    <li>
                                        <a href="{{$Category->getUrl()}}" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{url('categories/update/' . $Category->id)}}" method="post" enctype="multipart/form-data" files="true">
                            {{csrf_field()}}
                            <input name="noImage" type='hidden' id="noImage" />
                            <!-- Category Info-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group @if($errors->first('image'))has-error @endif">
                                    <input name="image" type='file' id="imgInp" />
                                    <div @if(!$Category->image)style="display: none!important;" @endif>
                                        <a href="#"  title="Delete image" class="delete-image"><span class="fa fa-close pull-right"></span></a>
                                        <img id="blah" src="@if($Category->image){{asset('assets/images/categories/' . $Category->image)}}@else#@endif" alt="your image" class="img-responsive product-image-large"/>
                                    </div>
                                    <span class="help-block">{{$errors->first('image')}}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">

                                <div class="form-group @if($errors->first('title'))has-error @endif">
                                    <label class="control-label" for="titleInput">Title*</label>
                                    <input name="title" type="text" value="@if(old('title')){{old('title')}}@else{{$Category->title}}@endif" class="form-control" id="titleInput" placeholder="Category title">
                                    <span class="help-block">{{$errors->first('title')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('description'))has-error @endif">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Category description">@if(old('description')){{old('description')}}@else{{$Category->description}}@endif</textarea>
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                </div>

                                <div class="form-group @if($errors->first('parent_category_id'))has-error @endif">
                                    <label class="control-label" for="parent_category_id">Parent category</label>
                                    <select class="form-control" name="parent_category_id" id="parent_category_id">
                                        <option value="">Select Parent Category</option>
                                        @foreach($Categories as $Cat)
                                            @if($Cat->id != $Category->id)
                                                <option value="{{$Cat->id}}" @if(old('parent_category_id') && old('parent_category_id') == $Cat->id) selected @elseif(!old('parent_category_id') && $Category->parent_category_id == $Cat->id) selected @endif>{{$Cat->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{$errors->first('parent_category_id')}}</span>
                                </div>

                                <div class="btn-group pull-right" role="group" style="margin-bottom:10px;margin-top:10px;">
                                    <button type="submit" class="btn btn-default btn-success"><span class="fa fa-check"></span> Update</button>
                                    <button type="button" class="btn btn-default btn-danger delete-category" data-toggle="modal" data-target="#deleteCategoryModal" data-id="{{$Category->id}}" data-title="{{$Category->title}}">
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

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Delete category</h4>
                </div>
                <div class="modal-body">
                    <div class="deleteMessage"></div>
                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post" action="{{url('categories/delete/' . $Category->id)}}">
                        {{csrf_field()}}
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
