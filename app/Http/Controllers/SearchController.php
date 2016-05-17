<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $Products = Product::where('title', 'LIKE', '%' . $request->srch . '%')
            ->orWhere('description', 'LIKE', '%' . $request->srch . '%')
            ->get();
        $Categories = Category::where('title', 'LIKE', '%' . $request->srch . '%')
            ->orWhere('description', 'LIKE', '%' . $request->srch . '%')
            ->get();
        return view('search')
            ->with(['srch' => $request->srch])
            ->with(['Products' => $Products])
            ->with(['Categories' => $Categories]);
    }
}
