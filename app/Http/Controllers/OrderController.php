<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\OrderMail;
use App\Item;
use App\Order;
use App\User;
class OrderController extends Controller
{
    //Add to Cart
    public function stage(Request $request)
    {
        $count = $request->session()->get('count');
        $orders = $request->session()->get('orders');
        $gettotal = $request->session()->get('total');
        $ctr = 0;
        $id = $request->input('hidden_id');
        $item = Item::find($id);
        $qty = $request->input('qty');
        if(session()->exists('orders')){
            foreach($orders as $key=>$order){
                if($order['id'] == $id){
                    $qty += $order['qty'];
                    $request->session()->forget('orders.'.$key);
                    $request->session()->push('orders', ['items' => $item, 'qty' => $qty, 'id' => $id, 'subtotal' => ($qty*$item->item_price)]);
                    return redirect('client');
                }
            }
        }
        $request->session()->push('orders', ['items' => $item, 'qty' => $qty, 'id' => $id, 'subtotal' => ($qty*$item->item_price)]);
        return redirect('client');
    }
    

    public function index(Request $request)
    {
        $cou = $request->session()->get('count');
        dd($cou);
        return view('/cart');
    }

    //Delete an item in cart
    public function pull(Request $request)
    {
        $orders = $request->session()->get('orders');
        unset($orders[$request->id]);
        session()->put('orders', $orders);
        return '/cart';
    }

    //Save all orders
    public function addorders(Request $request)
    {
        if(session()->exists('orders'))
        { 
            $msgs = array();
            $orderctr = 0;
            $keyctr = 0;
            $orders = $request->session()->get('orders');
            $newOrder = new Order();
            foreach($orders as $key=>$order)
            {
                $newOrder->user_id = Auth::user()->id;
                $newOrder->order_item = $order['items']->item_name;
                $newOrder->order_image = $order['items']->item_image;
                $item = Item::find($order['items']->id);
                if($item->item_stock >= $order['qty'])
                {
                    $newOrder->order_qty = $order['qty'];
                    $item->item_stock -= $order['qty'];
                    $newOrder->order_cost = $order['qty']*$order['items']->item_price;
                    $newOrder->save();
                    $item->save();
                    $orderctr++;
                }
                else{
                    $error = $order['items']->item_name.": ".$item->item_stock." pieces remaining. Sorry, order not added\n";
                    $msgs = Arr::add($msgs, $key, $error);
                    unset($order);
                }
                $keyctr++;
            }
            if($orderctr == $keyctr){
                Mail::to(Auth::user()->email)->send(new OrderMail());
            }
        }
        $request->session()->forget('count');
        $request->session()->forget('total');
        $request->session()->forget('orders');
        return response()->json($msgs);
    }

    //Get the current users orders
    public function myorders()
    {
        $id = Auth::user()->id;
        $myorders = User::find($id);
        return view('/myorders')->with('myorders', $myorders->order);
    }

    //Admin side : All orders
    public function allorders()
    {
        $orders = Order::all();
        return view("/allorders")->with('orders', $orders);
    }
}
