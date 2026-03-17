<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except(['_token','password_confirmation']);

        // upload avatar
        if ($request->hasFile('avatar')) {

            $path = $request->file('avatar')->store('users', 'public');

            $data['avatar'] = $path;
        }

        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success','Thêm người dùng thành công');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $data = $request->except(['_token','_method','password']);

        if ($request->hasFile('avatar')) {

            // xóa avatar cũ
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('users','public');
        }

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success','Cập nhật thành công');
    }

    public function destroy(User $user)
    {

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success','Xóa thành công');
    }
}