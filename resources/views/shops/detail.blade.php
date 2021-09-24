@extends('layouts.master')

@section('title') Product Detail @endsection

@section('content')
    <div class="col-sm-6 col-md-4 border border-danger">
        <div class="thumbnail clearfix">
            <div class="d-flex justify-content-center my-1">
                <img src="https://via.placeholder.com/300x300?text=example" alt="..." class="img-responsive">
            </div>
            <div class="caption">
                <h3 class="product-title">{{$product->title}}</h3>
                <p>{{$product->description}}</p>
                <form action="{{route('shop.order')}}" method="post" class="float-right mb-2">
                    @csrf
                    <input type="hidden" value="{{$product->id}}" name="id">
                    <input type="hidden" value="{{$product->title}}" name="name">
                    <input type="hidden" value="{{$product->description}}" name="description">
                    <input type="hidden" value="{{$product->price}}" name="price">
                    <button type="submit" class="btn btn-success ">Order</button>
                </form>
            </div>
            <div class="price font-weight-bold">
                <span>{{$product->price}}</span>
            </div>
        </div>
    </div>

@endsection
