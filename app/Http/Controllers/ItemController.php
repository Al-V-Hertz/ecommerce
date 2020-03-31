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
            request()->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name' => 'required',
                'price' => 'required|min: 1',
                'stock' => 'required|min: 0',
                'desc' => 'required'
            ]);
            $newItem = new Item();
            $newItem->item_name = $request->name;
            $newItem->item_desc = $request->desc;
            $newItem->item_price = $request->price;
            $newItem->item_stock = $request->stock;
            if ($file = $request->image) {
                $des = "images";
                $filename = rand().".".$file->getClientOriginalName();
                $file->move(public_path($des), $filename);
                $path = public_path().'/'.$des."/".$filename;
                $newItem->item_image = $path;
                $newItem->save();
                return "Success";
            }else{
                return "Failed";
            }
            // return "hello";
    }
}
