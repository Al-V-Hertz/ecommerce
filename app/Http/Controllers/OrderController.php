<?php

namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;
// use App\Item;
class OrderController extends Controller
{
    public function stage(Request $request)
    {
        $id = $request->input('hidden_id');
        $item = Item::find($id);
        $qty = $request->input('qty');
        // if(!$request->session()->has('orders')){
        $request->session()->push('orders',['items' => $item, 'qty' => $qty]);
            // $request->session()->push('orders.qty', $qty);
        return redirect('/client');
        // }else{
            // $request->session()->put('orders.item', $item);
            // $request->session()->put('orders.qty', $qty);
            // return redirect('/client');
        // }
    }
    public function show(Request $request){
        // $orders = $request->session()->get('orders');
        // // dd($orders);
        // ->with("orders", compact($orders));
        return view('/cart');
    }
}
