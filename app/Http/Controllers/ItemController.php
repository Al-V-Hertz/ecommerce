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
            if ($file = $request->file('image')) {
                // $image = $request->image->store('public/images');
                $file->move(base_path('/images'), $file->getClientOriginalName());
                $newItem->item_image = $file;
                $newItem->save();
                return Response()->json([
                    "success" => true,
                    "image" => $image
                ])
            }else{
                return Response()->json([
                    "success" => false,
                    "image" => ''
            ])
            }
    }
}
