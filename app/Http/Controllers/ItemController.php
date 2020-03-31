<?php

namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;
class ItemController extends Controller
{
    public function index(){
        $allItems = Item::all();
        return redirect()->route('admin', compact('items', $allItems));
    }

    public function store(Request $request){
        $newItem = new Item();
        $newItem->item_name = $request->itemname;
        $newItem->item_price = $request->itemprice;
        $newItem->item_stock = $request->itemstock;
        $newItem->save();
    }
}
