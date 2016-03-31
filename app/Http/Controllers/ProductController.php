<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Statistics;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Product Validate array
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'price' => 'required',
        'image' => 'image'
    ];

    /**
     * Show Product Info
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $Product = Product::find($id);
        if(!$Product) {
            abort(404);
        }
        $status = $Product ? 'sucess' : 'fail';
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Show pruduct info by id="' . $id . '"',
            'type' => 'read',
            'status' => $status,
        ]);
        $Statistics = Statistics::orderBy('created_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('event_type', 'view')
            ->where('item_type', 'product')
            ->where('item_id', $id)
            ->first();
        if (!$Statistics || strtotime($Statistics->created_at) + 86400 <= time()) {
            Statistics::create([
                'user_id' => Auth::user()->id,
                'event_type' => 'view',
                'item_type' => 'product',
                'item_id' => $id,
            ]);
        }
        return view('products.index')
            ->with(['Product' => $Product]);
    }

    /**
     * Create product
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->saveProduct($request);

            if (!$result['status']) {
                return redirect('products/create')
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('products/view/' . $result['Product']->id)
                ->with('success_message', 'Product has been created.');
        }
        $Categories = Category::all();
        return view('products.create')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Update Product Action
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $Product = Product::find($id);
        if(!$Product) {
            abort(404);
        }
        $Categories = Category::all();

        if ($request->isMethod('post') && $Product) {
            $result = $this->saveProduct($request, $Product);

            if (!$result['status']) {
                return redirect('products/update/' . $Product->id)
                    ->with(['Product' => $Product])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('products')
                ->with('success_message', 'Product has been updated.');
        }

        return view('products.update')
            ->with(['Product' => $Product, 'Categories' => $Categories]);
    }

    /**
     * Show Product Info
     * @param $id
     * @return $this
     */
    public function delete($id)
    {
        $Product = Product::find($id);
        try {
            $Product->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('products')
            ->with('success_message', 'Product has been deleted.');
    }

    /**
     * Show Product List
     * @return $this
     */
    public function productList()
    {
        $Products = Product::all();
        return view('products.list')
            ->with(['Products' => $Products]);
    }

    /**
     * Save Product
     * @param Request $request
     * @param Product|null $Product
     * @return Product
     */
    public function saveProduct(Request $request, Product $Product = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'validator' => $validator,
            ];
        }

        if (!$Product) {
            $Product = Product::create();
        }

        foreach ($request->all() as $key => $value) {
            if ($key != 'image' && $key != 'noImage' && in_array($key, $Product->map())) {
                $Product->{$key} = $value;
            }
        }

        if ($request->input('noImage')) {
            $filename = $Product->image;
            $Product->image = '';
            if($filename && file_exists(public_path() . '/assets/images/products/' . $filename)) {
                Storage::delete(public_path() . '/assets/images/products/' . $filename);
            }
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $Product->id . '_' . microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                if ($Product->image && file_exists(public_path() . '/assets/images/products/' . $Product->image)) {
                    @Storage::delete(public_path() . '/assets/images/products/' . $Product->image);
                }
                $file->move(public_path() . '/assets/images/products/', $filename);
                $Product->image = $filename;
            }
        }

        try {
            $Product->save();
        } catch (\Exception $e) {
            return $e;
        }

        return [
            'status' => true,
            'Product' => $Product
        ];
    }

    /**
     * Show products by category_id
     * @param $category_id
     * @return $this
     */
    public function productListByCategory($category_id)
    {
        $Products = Product::where('category_id', $category_id)->get();
        $Category = Category::find($category_id);
        return view('products.list')
            ->with(['Products' => $Products, 'Category' => $Category]);
    }
}
