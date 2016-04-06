<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Statistics;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    /**
     * Validate array
     *
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'image' => 'image'
    ];

    /**
     * Show Category Info view
     *
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $Category = Category::find($id);
        if (!$Category) {
            abort(404);
        }
        $User_id = 0;
        if (Auth::check()) {
            $User_id = Auth::user()->id;
        }
        $Statistics = Statistics::orderBy('created_at', 'desc')
            ->where('user_id', $User_id)
            ->where('event_type', 'view')
            ->where('item_type', 'category')
            ->where('item_id', $id)
            ->first();
        if (!$Statistics || strtotime($Statistics->created_at) + 86400 <= time()) {
            Statistics::create([
                'user_id' => $User_id,
                'event_type' => 'view',
                'item_type' => 'category',
                'item_id' => $id,
            ]);
        }
        return view('categories.index')
            ->with(['Category' => $Category]);
    }

    /**
     * Create category action
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->saveCategory($request);

            if (!$result['status']) {
                return redirect('categories/create')
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Create category, id="' . $result['Category']->id . '"',
                'type' => 'create',
                'status' => 'success',
            ]);

            return redirect('categories/view/' . $result['Category']->id)
                ->with('success_message', 'Category has been created.');
        }
        $Categories = Category::all();
        return view('categories.create')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Update Category Action
     *
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $Category = Category::find($id);
        if (!$Category) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update category info by id="' . $id . '"',
                'type' => 'update',
                'status' => 'failed',
            ]);
            abort(404);
        }
        if ($request->isMethod('post') && $Category) {
            $result = $this->saveCategory($request, $Category);

            if (!$result['status']) {
                return redirect('categories/update/' . $Category->id)
                    ->with(['Category' => $Category])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update category info by id="' . $id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);

            return redirect('categories')
                ->with('success_message', 'Category has been updated.');
        }
        $childrenCats = $this->getDisabledIds($Category);
        $Categories = Category::whereNotIn('id', $childrenCats)->get();

        return view('categories.update')
            ->with(['Category' => $Category, 'Categories' => $Categories]);
    }

    /**
     * Get all disabled categories ids
     *
     * @param $Category
     * @param array $array
     * @return array
     */
    public function getDisabledIds($Category, $array = [])
    {
        $array[] = $Category->id;
        if ($Category->children) {
            foreach ($Category->children as $children) {
                $array = $this->getDisabledIds($children, $array);
            }
        }
        return $array;
    }

    /**
     * Delete category action
     *
     * @param $id
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $Category = Category::find($id);
        foreach ($Category->products()->get() as $Product) {
            $Product->category_id = null;
            try {
                $Product->save();
            } catch (\Exception $e) {
                return $e;
            }
        }
        foreach ($Category->children as $Children) {
            $Children->parent_category_id = null;
            try {
                $Children->save();
            } catch (\Exception $e) {
                return $e;
            }
        }
        try {
            $Category->delete();
        } catch (\Exception $e) {
            return $e;
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Delete category by id="' . $id . '"',
            'type' => 'delete',
            'status' => 'success',
        ]);
        return redirect('categories')
            ->with('success_message', 'Category has been deleted.');
    }

    /**
     * Show Category List view
     *
     * @return $this
     */
    public function categoriesList()
    {
        $Categories = Category::where('parent_category_id', '<', 1)
            ->get();
        return view('categories.list')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Save Category action
     *
     * @param Request $request
     * @param Category|null $Category
     * @return array|\Exception
     */
    public function saveCategory(Request $request, Category $Category = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return ['status' => false, 'validator' => $validator,];
        }

        !$Category ? $Category = Category::create() : null;

        foreach ($request->all() as $key => $value) {
            if ($key != 'image' && $key != 'noImage' && in_array($key, $Category->map())) {
                $Category->{$key} = $value;
            }
        }

        if ($request->input('noImage')) {
            $filename = $Category->image;
            $Category->image = '';
            if ($filename && file_exists(public_path() . '/assets/images/categories/' . $filename)) {
                @Storage::delete(public_path() . '/assets/images/categories/' . $filename);
            }
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $Category->id . '_' . microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                if ($Category->image && file_exists(public_path() . '/assets/images/categories/' . $Category->image)) {
                    @Storage::delete(public_path() . '/assets/images/categories/' . $Category->image);
                }
                $file->move(public_path() . '/assets/images/categories/', $filename);
                $Category->image = $filename;
            }
        }

        try {
            $Category->save();
        } catch (\Exception $e) {
            return $e;
        }

        return ['status' => true, 'Category' => $Category];
    }
}
