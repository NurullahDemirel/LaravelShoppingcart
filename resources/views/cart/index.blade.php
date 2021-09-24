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
            <th scope="col">Without Tax</th>
            <th scope="col">tax</th>
            <th scope="col">price+tax</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(Cart::count())
            @foreach(Cart::content() as $item)
                <tr>
                    <th scope="row">{{$item->model->id}}</th>
                    <td>{{$item->model->title}}</td>
                    <td>{{$item->model->price}}</td>

                    <td id="{{'itemQuantity'.$item->rowId}}">{{$item->qty}}</td>
                    <td id="{{'itemWithoutTax'.$item->rowId}}">{{$item->model->price*$item->qty}}</td>
                    <td id="{{'itemTaxRate'.$item->rowId}}">{{$item->taxRate}}</td>
                    <td id="{{'itemSubTotal'.$item->rowId}}">{{$item->tax + $item->subtotal}}</td>

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

                        <div class="flex flex-col justify-center items-center">
                            <button onclick="updateQuantityPlus('{{$item->rowId}}')"><i class="fas fa-plus"></i></button>
                            <input type="text" id="{{'productQuantityInput'.$item->rowId}}" class="w-6 text-center" value="{{$item->qty}}"  onclick="updateQuantity({{$item->rowId}})">
                             <button onclick="updateQuantityMinus('{{$item->rowId}}')"><i class="fas fa-minus"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <div class="alert alert-danger">No items right now</div>
        @endif
        </tbody>
    </table>


    <div class="flex justify-end flex-col space-y-2 ml-auto border border-blue-500 rounded-lg">
        <span id="ticket-sub-total">Sub Total: {{Cart::subTotal()}}</span>
        <span id="ticket-tax">Tax: {{Cart::tax()}}</span>
        <span id="ticket-total">Total:{{Cart::total()}}</span>
    </div>
@endsection

@section('scripts')

    <script>
        function updateQuantityPlus(rowId){
            const id='#'+'productQuantityInput'+rowId;
            const quantity=$(id).val();
            $.ajax({
                type:'post',
                url:"{{route('shop.update')}}",
                data:{
                    quantity:quantity,
                    rowId:rowId
                },
                success:function (response){
                    change(response);
                }
            })
        }
        function updateQuantityMinus(rowId){
            const id='#'+'productQuantityInput'+rowId;
            const quantity=$(id).val();
            $.ajax({
                type:'post',
                url:"{{route('shop.update.minus')}}",
                data:{
                    quantity:quantity,
                    rowId:rowId
                },
                success:function (response){
                    change(response);
                }
            })
        }


        function change(response) {
            console.log(response)
            const qty = '#' + 'itemQuantity' + response.data.rowId;
            const itemWithoutTax = '#' + 'itemWithoutTax' + response.data.rowId;
            const input = '#' + 'productQuantityInput' + response.data.rowId;
            const itemSubTotal = '#' + 'itemSubTotal' + response.data.rowId;
            $(qty).html(response.data.qty);
            $(input).val(response.data.qty)
            $(itemSubTotal).html(response.subTotal);
            $(itemWithoutTax).html(response.withoutTax);
            $('#ticket-sub-total').html('Sub Total: '+ response.itemSub)
            $('#ticket-tax').html('Tax: '+ response.itemTax)
            $('#ticket-total').html('Total:'+ response.total);

        }
    </script>



@endsection
