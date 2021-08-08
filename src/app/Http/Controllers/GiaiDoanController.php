<?php

namespace App\Http\Controllers;

use App\Models\GiaiDoanHoTro;
use App\Models\DonVi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddGiaiDoanRequest;
class GiaiDoanController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->ltk_id == 2) {
            $giaidoans = GiaiDoanHoTro::whereRaw('dv_id = ?',Auth::user()->dv_id)->get();
            foreach ($giaidoans as $giaidoan) {
                $giaidoan->chitiet;
            }
            return response()->json($giaidoans);
        }

        $giaidoans = GiaiDoanHoTro::all();
        foreach ($giaidoans as $giaidoan) {
            $giaidoan->chitiet;
        }
        return response()->json($giaidoans);
    }

    public function store(AddGiaiDoanRequest $request)
    {
        $giaidoan = new GiaiDoanHoTro;
        $giaidoan->fill($request->except('dv_id'));
        $idDv = Auth::user()->dv_id;
        
        if (Auth::user()->ltk_id == 1){
            $idDv = $request->dv_id;
            if(!DonVi::find($idDv) )
                return response()->json(['message' => 'Don vi khong ton tai'],400);
        }

        $checkDuplicate = GiaiDoanHoTro::whereRaw('gd_tunam = ? and gd_dennam = ? and dv_id = ?', array($request->gd_tunam, $request->gd_dennam, $idDv))->get();
        if (count($checkDuplicate) > 0){
            return response()->json(['message' => 'Giai doan bi trung'],400);
        }

        $giaidoan->dv_id = $idDv;
        $giaidoan->save();
        return response()->json(['message' => 'Thanh cong', 'giaidoan' => $giaidoan]);
    }

    public function update(Request $request, $id)
    {
        $giaidoan = GiaiDoanHoTro::find($id);
        if (!$giaidoan)
            return response()->json(['message' => 'Khong tim thay thong tin '],400);
        if ($giaidoan->dv_id != Auth::user()->dv_id && Auth::user()->ltk_id == 2 )
            return response()->json(['message' => 'Khong co quyen nay '],401);

        if(Auth::user()->ltk_id == 1)
            $giaidoan->dv_id = $request->dv_id;
        if (Auth::user()->ltk == 2)
            $giaidoan->dv_id = Auth::user()->dv_id;

        $giaidoan->fill($request->except('dv_id'));
        $giaidoan->save();
        return response()->json(['message' => 'Thanh cong', 'giaidoan' => $giaidoan]);
    }
    public function destroy(Request $request, $id)
    {
        $giaidoan = GiaiDoanHoTro::find($id);

        if (!$giaidoan)
            return response()->json(['message' => 'Khong tim thay thong tin '],400);

        if (Auth::user()->ltk == 2 && $giaidoan->dv_id != Auth::user()->dv_id)
            return response()->json(['message' => 'Khong co quyen o don vi nay'],401);

        $giaidoan->delete();
        return response()->json(['message' => 'Thanh cong']);
    }
}
