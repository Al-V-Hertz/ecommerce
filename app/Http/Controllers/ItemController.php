<?php

namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;
use DataTables;
class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn ="<button id = '$row->id' class='btn btn-primary edit'>Edit</button>";
                           $btn= $btn."  <button id='$row->id' class='btn btn-danger delete'>Delete</button>";
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function store(Request $request)
    {
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                $path = $des."/".$filename;
                $newItem->item_image = $path;
                $newItem->save();
                return "Success";
            }else{
                return "Failed";
            }
    }

    public function get(Request $request)
    {
        $data = Item::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $updItem = Item::find($request->uid);
        if($file = $request->uimage){
            $des = "images";
            $filename = rand().".".$file->getClientOriginalName();
            $file->move(public_path($des), $filename);
            unlink($updItem->item_image);
            $path = $des."/".$filename;
            $updItem->item_image = $path;
        }
        $updItem->item_name = $request->uname;
        $updItem->item_desc = $request->udesc;
        $updItem->item_price = $request->uprice;
        $updItem->item_stock = $request->ustock; 
        $updItem->save();
        return "success?";
    }

    public function destroy(Request $request)
    {
        $del = Item::find($request->id);
        if($del->item_image){
            unlink($del->item_image);
        }
        $del->delete();
    
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    //CLIENT SIDE//
    public function show()
    {
        $cards = Item::all();
        return view('client', compact('cards'));
    }
    
    public function details(Request $request)
    {
        $det = Item::find($request->id);
        // dd($det);
        return response()->json($det);
    }
}
