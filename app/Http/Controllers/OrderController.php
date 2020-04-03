<?php

namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;
// use App\Item;
class OrderController extends Controller
{
    public function stage(Request $request)
    {
        
        $orders = $request->session()->get('orders');
        $id = $request->input('hidden_id');
        $item = Item::find($id);
        $qty = $request->input('qty');
        $request->session()->push('orders', ['items' => $item, 'qty' => $qty]);
        return redirect('/cart');
        // dd($orders);/client');
    }

    public function index(Request $request){
        // $orders = $request->session()->get('orders');
        // // dd($orders);
        // foreach($orders as $key => $order){
        //     dd($orders);
        // }

        return view('/cart');
    }

    public function pull(Request $request){
        $orders = $request->session()->get('orders');
        unset($orders[$request->id]);
        session()->put('orders', $orders);
        return '/cart';
    }

    public function total(Request $request){
        $orders = $request->session()->get('orders');
        // $total = sum($orders['items']['item_price']*$orders['qty']);
        // foreach($orders as $order){
        //     $total += $order['']
        // }
        return response()->json($total);
    }
}
