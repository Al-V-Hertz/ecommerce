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
        $request->session()->push('orders',['items' => $item, 'qty' => $qty]);
        return redirect('/client');
    }
    public function index(Request $request){
        // $orders = $request->session()->get('orders');
        // dd($orders);
        // ->with("orders", compact($orders));
        return view('/cart');
    }

    public function grandtotal(){
        
    }
}
