<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $data = Category::with('subCategories')->get();

        return response()->json(['success' => true, 'data' => $data],200);
    }
}
