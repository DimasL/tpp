<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Statistics;
use App\Http\Requests;
use App\Models\UsersSubscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class ProductController extends Controller
{

    /**
     * Product Validate array
     *
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'price' => 'numeric',
        'quantity' => 'numeric',
        'image' => 'image'
    ];

    /**
     * Show Product Info view
     *
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $User_id = 0;
        if (Auth::check()) {
            $User_id = Auth::user()->id;
        }
        $Product = Product::find($id);
        if (!$Product) {
            abort(404);
        }
        $Statistics = Statistics::orderBy('created_at', 'desc')
            ->where('user_id', $User_id)
            ->where('event_type', 'view')
            ->where('item_type', 'product')
            ->where('item_id', $id)
            ->first();
        if (!$Statistics || strtotime($Statistics->created_at) + 86400 <= time()) {
            Statistics::create([
                'user_id' => $User_id,
                'event_type' => 'view',
                'item_type' => 'product',
                'item_id' => $id,
            ]);
        }
        return view('products.index')
            ->with(['Product' => $Product]);
    }

    /**
     * Create product action
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
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

            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Create product, id="' . $result['Product']->id . '"',
                'type' => 'create',
                'status' => 'success',
            ]);

            return redirect('products/view/' . $result['Product']->id)
                ->with('success_message', 'Product has been created.');
        }
        $Categories = Category::all();
        return view('products.create')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Update Product action
     *
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $Product = Product::find($id);
        if (!$Product) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update product, id="' . $id . '"',
                'type' => 'update',
                'status' => 'failed',
            ]);
            abort(404);
        }
        if ($request->isMethod('post') && $Product) {
            $result = $this->saveProduct($request, $Product);
            if (!$result['status']) {
                return redirect('products/update/' . $Product->id)
                    ->with(['Product' => $Product])
                    ->withInput()
                    ->withErrors($result['validator']);
            }
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update product, id="' . $id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);
            return redirect('products')
                ->with('success_message', 'Product has been updated.');
        }

        return view('products.update')
            ->with(['Product' => $Product, 'Categories' => Category::all()]);
    }

    /**
     * Delete Product action
     *
     * @param $id
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            Product::find($id)->delete();
        } catch (\Exception $e) {
            return $e;
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Delete product, id="' . $id . '"',
            'type' => 'delete',
            'status' => 'success',
        ]);
        return redirect('products')
            ->with('success_message', 'Product has been deleted.');
    }

    /**
     * Show Product List view
     *
     * @return $this
     */
    public function productList()
    {
        return view('products.list')
            ->with(['Products' => Product::paginate()]);
    }

    /**
     * Save Product action
     *
     * @param Request $request
     * @param Product|null $Product
     * @return array|\Exception
     */
    public function saveProduct(Request $request, Product $Product = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return ['status' => false, 'validator' => $validator];
        }

        if (!$Product) {
            $Product = Product::create();
        }

        if ($request->category_id && $Product->category_id != $request->category_id) {
            $Category = Category::find($request->category_id);
            $UsersSubscriptions = UsersSubscriptions::where('item_type', 'categories')
                ->where('item_id', $request->category_id)
                ->get();
            $emails = [];
            foreach ($UsersSubscriptions as $UsersSubscription) {
                $emails[] = $UsersSubscription->user->email;
            }
            Mail::send('emails.newproductincategory', ['Product' => $Product, 'Category' => $Category], function ($message) use ($emails, $Product) {
                $message->to($emails)->subject('New product!');
            });
        }

        if ($request->quantity > 0 && $Product->quantity < 1) {
            $UsersSubscriptions = UsersSubscriptions::where('item_type', 'products')
                ->where('item_id', $Product->id)
                ->get();
            $emails = [];
            foreach ($UsersSubscriptions as $UsersSubscription) {
                $emails[] = $UsersSubscription->user->email;
            }
            Mail::send('emails.productexist', ['Product' => $Product], function ($message) use ($emails) {
                $message->to($emails)->subject('Product is available!');
            });
        }

        foreach ($request->all() as $key => $value) {
            if ($key != 'image' && $key != 'noImage' && in_array($key, $Product->map())) {
                $Product->{$key} = $value;
            }
        }

        if ($request->input('noImage')) {
            $filename = $Product->image;
            $Product->image = '';
            if ($filename && file_exists(public_path() . '/assets/images/products/' . $filename)) {
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

        return ['status' => true, 'Product' => $Product];
    }

    /**
     * Show products action
     *
     * @param $category_id
     * @return $this
     */
    public function productListByCategory($category_id)
    {
        $Products = Product::where('category_id', $category_id)
            ->paginate();
        $Category = Category::find($category_id);
        return view('products.list')
            ->with(['Products' => $Products, 'Category' => $Category]);
    }
}
