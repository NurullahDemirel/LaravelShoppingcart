@extends('layouts.master')


@section('title') Cart @endsection

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">tax</th>
            <th scope="col">price+tax</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(Cart::instance('saveForLater')->count())
            @foreach(Cart::instance('saveForLater')->content() as $item)
                <tr>
                    <th scope="row">{{$item->model->id}}</th>
                    <td>{{$item->model->title}}</td>
                    <td>{{$item->model->price}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{$item->taxRate}}</td>
                    <td>{{$item->tax + $item->subtotal}}</td>
                    <td class="d-flex align-items-center space-x-2">
                        <form action="{{route('shop.destroy')}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{$item->rowId}}">
                            <button class="btn btn-danger" type="submit">Remove</button>
                        </form>
                        <form action="{{route('shop.switchToSaveForLater')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->rowId}}">
                            <button class="btn btn-success" type="submit">Switch To For Later </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <div class="alert alert-danger">No items right now</div>
        @endif
        </tbody>
    </table>
@endsection
