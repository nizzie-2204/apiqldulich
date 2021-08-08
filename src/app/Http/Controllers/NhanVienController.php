<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use App\Models\DonVi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = new User;

        $user = Auth::user();

        $user->donvi;
        $user->dangkytour;
        if (!$user) 
            return response()->json(['message' => 'Co loi'],400);

        return response()->json(['message' => 'Thanh cong', 'nhanvien' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        $user = new  User;
        $user->fill($request->except(['dv_id', 'password', 'username','ltk_id']));
        
        if (Auth::user()->ltk_id == 1){
            if (!DonVi::find($request->dv_id))
                return response()->json(['message'=> 'Don vi khong ton tai'],400);
            else {
                $user->dv_id = $request->dv_id;
                $user->ltk_id = $request->ltk_id;
            }
        } 
        if (Auth::user()->ltk_id == 2) {
            $user->dv_id = Auth::user()->dv_id;
        } 

        $makePassword = Str::random(8);

        $spitName = explode(' ', Str::lower($request->nv_ten));
        $makeUsername = end($spitName) . rand(000000, 999999);

        $hashPass = Hash::make($makePassword);
        $user->username = $makeUsername;
        $user->password = $hashPass;


        $user->save();


        return response()->json(['message' => 'Them nhan vien thanh cong', 'username' => $makeUsername, 'password' => $makePassword, 'nhanvien' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::with('donvi')->find($id);
        if (!$user)
            return  response()->json(['message' => 'Khong co nhan vien nay'],400);

        if ($user->ltk_id == 1 && Auth::user()->ltk_id != 1)
            return  response()->json(['message' => 'Khong co quyen truy cap'], 401);
        return  response()->json($user ? $user : 'Khong tim thay nhan vien');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        //
        $id = Auth::user()->id;
        $user = User::find($id)->fill($request->except('password', 'dv_id'));

        if ($request->password) {
            $password = Hash::make($request->password);
            $user->password = $password;
        }
        $user->save();
        return response()->json([['message' => 'Thanh cong', 'nhanvien' => $user]]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $nhanvien = User::find($id);

        if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != $nhanvien->dv_id)
            return response()->json(['message' => 'Khong co quyen thao tac cua don vi nay']);

        $msgError = '';

        if ($nhanvien) {
            $nhanvien->delete();
            $msgError = 'Xoa thanh cong nhan vien ' . $id;
        } else $msgError = 'Khong tim thay nhan vien ' . $id;

        return response()->json(['message' => $msgError]);
    }

    public function login(Request $request)
    {
        $login = Auth::attempt(['username' => $request->username, 'password' => $request->password]);

        if (!$login) {
            return response()->json(['message' => 'Tai khoan hoac mat khau khong dung'],401);
        }

        $user = Auth::user();
        $user->donvi;
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json(['message' => $user, 'Token' => $accessToken]);
    }

    public function logout()
    {
        if (Auth::check())
            Auth::user()->token()->delete();
        return response()->json(['message' => 'Dang xuat thanh cong']);
    }

    public function all()
    {
        if (Auth::user()->ltk_id == 1)
            return response()->json(User::with(['donvi'])->get());

        return User::with('donvi')->where('dv_id', Auth::user()->dv_id)->get();
    }

    public function edit(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
            return  response()->json(['message' => 'Khong co nhan vien nay'],400);


        if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != $user->dv_id) {
            return  response()->json(['message' => 'Khong co quyen truy cap'],401);
        }

        $user->fill($request->except('password', 'dv_id', 'username'));
        if ($request->password == '')
        $password = $user->password;
        else $password = Hash::make($request->password);
        $user->password = $password;
        if (Auth::user()->ltk_id == 1) {
            $user->dv_id = $request->dv_id;
        }
        $user->save();

        return  response()->json(['message' => 'Sua thanh cong', 'nhanvien' => $user]);
    }

    public function history()
    {
        $idDV = Auth::user()->dv_id;
        if (Auth::user()->ltk_id == 2){
            $users = User::onlyTrashed()->where('dv_id', '=', $idDV)->get();
            foreach ($users as $user) {
                $user->donvi;
            }
            return response()->json(['message' => 'Thanh cong', 'nhanvien' => $users]);
        }
        if (Auth::user()->ltk_id == 1){
            $users = User::onlyTrashed()->get();
            foreach ($users as $user) {
                $user->donvi;
            }
            return response()->json(['message' => 'Thanh cong', 'nhanvien' => $users]);
        }
    }

    public function restore($id)
    {
        $user =  User::onlyTrashed()->find($id);
        if ($user) {
            if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != $user->dv_id)
                return  response()->json(['message' => 'Khong co quyen truy cap'],401);

            $user->restore();
            return  response()->json(['message' => 'Khoi phuc thanh cong']);
        }

        return  response()->json(['message' => 'Khong tim thay nhan vien'],400);
    }
}
