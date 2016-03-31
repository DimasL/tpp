@extends('layouts.master')

@section('products_active') active @stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Products list @if(isset($Category))(Category: <a href="{{ url('/categories/view/' . $Category->id) }}">{{ $Category->title }}</a>) @endif
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 text-right">
                                <ul class="list-inline top-buttons-ul">
                                    @if(Auth::user()->isUserCan('create'))
                                        <li>
                                            <a href="{{url('products/create')}}" title="Add Product">
                                                <i class="fa fa-plus"></i> Add
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($Products->count())
                            <table class="table table-striped">
                                <thead>
                                    <td class="text-center">#</td>
                                    <td class="text-center">Sku</td>
                                    <td class="text-center">Category</td>
                                    <td class="text-center">Title</td>
                                    <td class="text-center">Price</td>
                                    <td class="text-center">Created at</td>
                                    <td class="text-right"></td>
                                </thead>
                                <tbody>
                                    @foreach($Products as $key => $Product)
                                        <tr>
                                            <td class="text-center">{{$key}}</td>
                                            <td class="text-center">{{$Product->sku}}</td>
                                            <td class="text-center">{{$Product->getCategoryTitle()}}</td>
                                            <td class="text-center">{{$Product->title}}</td>
                                            <td class="text-center">{{$Product->price}}</td>
                                            <td class="text-center">{{$Product->created_at}}</td>
                                            <td class="text-right">
                                                <a href="{{url('products/view/' . $Product->id)}}" title="More info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(Auth::user()->isUserCan('update'))
                                                    <a href="{{url('products/update/' . $Product->id)}}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No products.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
