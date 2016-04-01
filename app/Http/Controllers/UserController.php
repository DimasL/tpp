<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * User Validate array
     * @var array
     */
    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'image' => 'image'
    ];

    /**
     * Show User Info view
     *
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $User = User::find($id);
        if(!$User) {
            abort(404);
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Show user info by id="' . $id . '"',
            'type' => 'read',
            'status' => 'success',
        ]);
        return view('users.index')
            ->with(['User' => $User]);
    }

    /**
     * Show User Info view
     *
     * @return $this
     */
    public function profile()
    {
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Show user info by id="' . Auth::user()->id . '"',
            'type' => 'read',
            'status' => 'success',
        ]);
        return view('users.index')
            ->with(['User' => Auth::user()]);
    }

    /**
     * Create user action
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->saveUser($request);

            if(!$result['status']) {
                return redirect('users/create')
                    ->withInput()
                    ->withErrors($result['validator']);
            }
            return redirect('users/view/' . $result['User']->id)
                ->with('success_message', 'User has been created.');
        }
        return view('users.create');
    }

    /**
     * Update User action
     *
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $User = User::find($id);
        if(!$User) {
            abort(404);
        }
        $Roles = Role::all();
        if ($request->isMethod('post') && $User) {
            $result = $this->saveUser($request, $User);

            if(!$result['status']) {
                return redirect('users/update/' . $User->id)
                    ->with(['User' => $User])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('users/view/' . $User->id)
                ->with('success_message', 'User has been updated.');
        }
        return view('users.update')
            ->with(['User' => $User, 'Roles' => $Roles]);
    }

    /**
     * Update Profile action
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $User = Auth::user();
        if(!$User) {
            abort(404);
        }
        if ($request->isMethod('post') && $User) {
            $result = $this->saveUser($request, $User);

            if(!$result['status']) {
                return redirect('profile/update')
                    ->with(['User' => $User])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('profile')
                ->with('success_message', 'Profile has been updated.');
        }
        return view('users.update')
            ->with(['User' => $User]);
    }

    /**
     * Delete User action
     *
     * @param $id
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            User::find($id)->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('users')
            ->with('success_message', 'User has been deleted.');
    }

    /**
     * Show User List view
     *
     * @return $this
     */
    public function userList()
    {
        return view('users.list')
            ->with(['Users' => User::paginate()]);
    }

    /**
     * Save User action
     *
     * @param Request $request
     * @param User|null $User
     * @return array|\Exception
     */
    public function saveUser(Request $request, User $User = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return ['status' => false,'validator' => $validator];
        }

        if(!$User) {
            $User = User::create();
            $User->roles()->sync([2]);
        }

        foreach($request->all() as $key => $value) {
            if($key != 'image' && $key != 'noImage' && in_array($key, $User->map())) {
                $User->{$key} = $value;
            }
        }

        if($request->input('role')) {
            $User->roles()->sync([$request->input('role')]);
        }

        if($request->input('noImage')) {
            $filename = $User->image;
            $User->image = '';
            if($filename && file_exists(public_path() . '/assets/images/users/' .$filename)) {
                Storage::delete(public_path() . '/assets/images/users/' . $filename);
            }
        } else {
            if( $request->hasFile('image') ) {
                $file = $request->file('image');
                $filename = $User->id . '_' . microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                if($User->image && file_exists(public_path() . '/assets/images/users/' . $User->image)) {
                    @Storage::delete(public_path() . '/assets/images/users/' . $User->image);
                }
                $file->move(public_path() .'/assets/images/users/', $filename);
                $User->image = $filename;
            }
        }

        try {
            $User->save();
        } catch(\Exception $e) {
            return $e;
        }

        return ['status' => true,'User' => $User];
    }
}
