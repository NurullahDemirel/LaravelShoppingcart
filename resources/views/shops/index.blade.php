@extends('layouts.master')

@section('title') Laravel Shopping Cart @endsection

@section('content')
    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-6 col-md-4 border border-danger">
                <div class="thumbnail">
                    <div class="d-flex justify-content-center my-1">
                        <img src="https://via.placeholder.com/300x300?text=example" alt="..." class="img-responsive">
                    </div>
                    <div class="caption">
                        <h3 class="product-title">{{$product->title}}</h3>
                        <p>{{$product->description}}</p>
                        <a href="{{route('products.show',$product)}}" class="btn btn-success float-right mb-2" role="button">Look</a>
                    </div>
                    <div class="price font-weight-bold">
                        <span>{{$product->price}}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
