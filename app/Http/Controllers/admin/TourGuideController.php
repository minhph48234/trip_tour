<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourGuide;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TourGuideController extends Controller
{

    /*
    |------------------------------------------
    | DANH SÁCH HƯỚNG DẪN VIÊN
    |------------------------------------------
    */
    public function index()
    {
        $guides = TourGuide::latest()->get();

        return view('admin.guides.index', compact('guides'));
    }


    /*
    |------------------------------------------
    | FORM THÊM HƯỚNG DẪN VIÊN
    |------------------------------------------
    */
    public function create()
    {
        return view('admin.guides.create');
    }


    /*
    |------------------------------------------
    | LƯU HƯỚNG DẪN VIÊN
    |------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'experience' => 'required'
        ]);


        DB::beginTransaction();

        try {

            /*
            |-----------------------------------------
            | 1. TẠO USER LOGIN
            |-----------------------------------------
            */

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make('123456'),
                'role' => 'guide',
                'status' => 1
            ]);


            /*
            |-----------------------------------------
            | 2. TẠO TOUR GUIDE
            | user_id = id của user vừa tạo
            |-----------------------------------------
            */

            TourGuide::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'experience' => $request->experience,
                'status' => 1
            ]);


            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error','Có lỗi xảy ra khi tạo hướng dẫn viên');
        }


        return redirect()
            ->route('admin.guides.index')
            ->with('success','Thêm hướng dẫn viên thành công');
    }


    /*
    |------------------------------------------
    | FORM SỬA GUIDE
    |------------------------------------------
    */
    public function edit($id)
    {

        $guide = TourGuide::findOrFail($id);

        return view('admin.guides.edit', compact('guide'));
    }


    /*
    |------------------------------------------
    | UPDATE GUIDE
    |------------------------------------------
    */
    public function update(Request $request, $id)
    {

        $guide = TourGuide::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'experience' => 'required'
        ]);


        DB::beginTransaction();

        try {

            /*
            |-----------------------------------------
            | UPDATE USER
            |-----------------------------------------
            */

            $user = User::find($guide->user_id);

            if($user){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);
            }


            /*
            |-----------------------------------------
            | UPDATE TOUR GUIDE
            |-----------------------------------------
            */

            $guide->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'experience' => $request->experience,
                'status' => $request->status ?? 1
            ]);


            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error','Cập nhật thất bại');
        }


        return redirect()
            ->route('admin.guides.index')
            ->with('success','Cập nhật hướng dẫn viên thành công');
    }


    /*
    |------------------------------------------
    | XÓA GUIDE
    |------------------------------------------
    */
    public function destroy($id)
    {

        $guide = TourGuide::findOrFail($id);

        DB::beginTransaction();

        try {

            /*
            |-----------------------------------------
            | XÓA USER
            |-----------------------------------------
            */

            User::where('id',$guide->user_id)->delete();


            /*
            |-----------------------------------------
            | XÓA TOUR GUIDE
            |-----------------------------------------
            */

            $guide->delete();


            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error','Xóa thất bại');
        }


        return redirect()
            ->route('admin.guides.index')
            ->with('success','Xóa hướng dẫn viên thành công');
    }

}