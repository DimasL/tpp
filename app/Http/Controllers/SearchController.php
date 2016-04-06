<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

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


//        $perPage = 5;
//        $Categories = DB::table('categories')
//            ->where('title', 'LIKE', '%' . $request->srch . '%')
//            ->orWhere('description', 'LIKE', '%' . $request->srch . '%')
//            ->select('id', 'title', 'description');
//        $Search = DB::table('products')
//            ->where('title', 'LIKE', '%' . $request->srch . '%')
//            ->orWhere('description', 'LIKE', '%' . $request->srch . '%')
//            ->select('id', 'title', 'description')
//            ->union($Categories)
//            ->get();
//        if($request->page) {
//            $Search = array_slice($Search, ($perPage * $request->page) - 1, ($perPage * $request->page) + $request->page);
//        }

        return view('search')
            ->with(['srch' => $request->srch])
            ->with(['Products' => $Products])
            ->with(['Categories' => $Categories]);
    }
}
