<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Item;
use App\Order;

class OrderController extends Controller
{
    public function stage(Request $request)
    {
        $orders = $request->session()->get('orders');
        $id = $request->input('hidden_id');
        $item = Item::find($id);
        $qty = $request->input('qty');
        if(session()->exists('orders')){
            foreach($orders as $key=>$order){
                if($order['id'] == $id){
                    $qty += $order['qty'];
                    $request->session()->forget('orders.'.$key);
                    // unset($orders[$key]);
                    $request->session()->push('orders', ['items' => $item, 'qty' => $qty, 'id' => $id]);
                    return redirect('client');
                }
            }
        }
        $request->session()->push('orders', ['items' => $item, 'qty' => $qty, 'id' => $id]);
        return redirect('client');
    }
    
    public function index(Request $request)
    {
        // $orders = $request->session()->get('orders');
        // dd($orders);
        return view('/cart');
    }

    public function pull(Request $request)
    {
        $orders = $request->session()->get('orders');
        unset($orders[$request->id]);
        session()->put('orders', $orders);
        return '/cart';
    }

    public function total(Request $request)
    {
        $orders = $request->session()->get('orders');
        // $total = sum($orders['items']['item_price']*$orders['qty']);
        // foreach($orders as $order){
        //     $total += $order['']
        // }
        return response()->json($total);
    }

    public function addorders(Request $request)
    {
        if(session()->exists('orders'))
        { 
            $orders = $request->session()->get('orders');
            $newOrder = new Order();
            foreach($orders as $key=>$order)
            {
                $newOrder->client_id = Auth::user()->id;
                $newOrder->order_item = $order['items']->item_name;
                $item = Item::find($order['items']->id);
                if($item->item_stock >= $order['qty'])
                {
                    $newOrder->order_qty = $order['qty'];
                    $item->item_stock -= $order['qty'];
                    $newOrder->order_cost = $order['qty']*$order['items']->item_price;
                    $newOrder->save();
                    $item->save();
                }
                else{
                    $error = $order['items']->item_name." stock is insufficient: ".$item->item_stock." pieces remaining. Sorry, order not added";
                    $msgs = Arr::add($msgs, $key, $error);
                }
            }
        }
        // return redirect()->route('myorders')->with("messages", $msgs);
        $request->session()->forget('orders');
        return redirect()->route('cart');
    }

    public function myorders()
    {
        return view('/myorders');
    }
}
