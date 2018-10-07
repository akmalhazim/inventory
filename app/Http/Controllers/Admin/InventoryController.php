<?php

namespace App\Http\Controllers\Admin;

use App\Borrower;
use App\Inventory;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class InventoryController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'category_id' => 'required|integer',
            'quantity' => 'required|integer',
            'region' => 'required|string',
            'image' => 'required|image'
        ]);

        $img = $request->file('image');
        $image = Image::make($img)->resize(150,null,function ($constraint) {
            $constraint->aspectRatio();
        });
        $filename = time() . '_' . rand(20000,100000) . '.' . $img->getClientOriginalExtension();
        $image->save(public_path('/images/'.$filename));
        $inventory = new Inventory;
        $inventory->name = $request->name;
        $inventory->added_by_user_id = Auth::id();
        $inventory->category_id = $request->category_id;
        $inventory->quantity = $request->quantity;
        $inventory->quantity_deducted = 0;
        $inventory->region = $request->region;
        $inventory->image = $filename;
        $inventory->save();
        return response()->json(['success' => true],201);
    }
    public function index() {
        if(Auth::user()->role_id === 1) {
            $data = Inventory::with(['category'])->get();
        } else {
            $data = Inventory::with(['category'])->where('added_by_user_id', Auth::id())->get();
        }
        return response()->json(['data' => $data],200);
    }
    public function destroy($id) {
        $inventory = Inventory::findOrFail($id);
        Storage::disk('inventory')->delete($inventory->image);
        $inventory->delete();
        return response()->json(['success' => true],201);
    }
    public function update(Request $r) {
        $this->validate($r, [
            'name' => 'string',
            'image' => 'image',
            'category_id' => 'integer',
            'quantity' => 'integer',
            'region' => 'string'
        ]);
        $request = $r->only(['name','image','category_id','quantity','region']);

        $inventory = Inventory::findOrFail($r->inventory_id);

        foreach($request as $key => $val) {
            $inventory->$key = $val;
        }
        $inventory->save();

        return response()->json(['success' => true, 'data' => $inventory],201);
    }
    public function show($id) {
        $inventory = Inventory::findOrFail($id)->load('category.subCategory');
        $categories = SubCategory::all();
        return response()->json(['data' => $inventory, 'categories' => $categories],200);
    }
    public function getBorrower($id) {
        $borrower = Borrower::with('user')->where('inventory_id', $id)->get();
        return response()->json(['data' => $borrower],200);
    }
}
