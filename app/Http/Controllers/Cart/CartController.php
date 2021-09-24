<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Peoduct\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }
    public function order(Request $request)
    {
         Cart::add($request->id,$request->name,1,$request->price,['description'=>$request->description])->associate(Product::class);
            return redirect()->route('shop.cart')->with('success','product added successfully to pocket ');
    }

    public function destroy(Request $request)
    {
        Cart::remove($request->id);
        return back()->with('success', 'item was removed successfully from pocket');
    }
    public function update(Request $request ){
        Cart::update($request->rowId,$request->quantity+1);
        $item=Cart::get($request->rowId);
        $withoutTax=$item->model->price*$item->qty;
        $itemSub=Cart::subTotal();
        $tax=Cart::tax();
        $total=Cart::total();
        return response()->json(['data'=>$item,'subTotal'=>$item->subtotal,'itemSub'=>$itemSub,'itemTax'=>$tax,'total'=>$total,'withoutTax'=>$withoutTax]);
    }
    public function minus(Request $request ){
        Cart::update($request->rowId,$request->quantity-1);
        $item=Cart::get($request->rowId);
        $withoutTax=$item->model->price*$item->qty;
        $itemSub=Cart::subTotal();
        $tax=Cart::tax();
        $total=Cart::total();
        return response()->json(['data'=>$item,'subTotal'=>$item->subtotal,'itemSub'=>$itemSub,'itemTax'=>$tax,'total'=>$total,'withoutTax'=>$withoutTax]);

    }

    public function switchToSaveForLater(Request $request)
    {
        $item=Cart::get($request->id);
        if (Cart::get($request->id)->qty == 1){
            Cart::remove($request->id);

        }
        else{
            Cart::update($request->id,Cart::get($request->id)->qty-1);
        }
        Cart::instance('saveForLater')->add($item->id,$item->name,1,$item->price)->associate(Product::class);
        return redirect()->route('shop.cart')->with('success','item was added for later');
    }

    public function saves()
    {
        return view('shops.saves');
    }

}
