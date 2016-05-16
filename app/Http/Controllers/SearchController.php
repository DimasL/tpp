<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use sngrl\SphinxSearch\SphinxSearch;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $sphinx = new SphinxSearch();
        $Products = Product::whereIn('id', array_column(json_decode(json_encode($sphinx->search($request->srch, 'product')->get()), true), 'id'))
            ->get();
        $Categories = Category::whereIn('id', array_column(json_decode(json_encode($sphinx->search($request->srch, 'category')->get()), true), 'id'))
            ->get();

        return view('search')
            ->with(['srch' => $request->srch])
            ->with(['Products' => $Products])
            ->with(['Categories' => $Categories]);
    }
}
