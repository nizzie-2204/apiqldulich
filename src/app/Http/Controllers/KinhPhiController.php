<?php

namespace App\Http\Controllers;

use App\Models\ChiTietGiaiDoanHoTro;
use App\Models\GiaiDoanHoTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KinhPhiController extends Controller
{
    //
    public function index()
    {
        $details = ChiTietGiaiDoanHoTro::all();


        foreach ($details as $detail) {
            $detail->giaidoan->donvi;
        }
        return response()->json($details);
    }


    public function store(Request $request, $id)
    {
        $ctgdhotro = new ChiTietGiaiDoanHoTro;
        $giaidoan = GiaiDoanHoTro::find($id);

        if (!$giaidoan)
            return response()->json(['message'=>'Khong tim thay giai doan'],400);
        
        if (Auth::user()->ltk_id == 1)
            $dvid = $request->dv_id;
        if (Auth::user()->ltk_id == 2)
            $dvid = Auth::user()->dv_id;


        $ctgdhotro->ctgdhotro_tuthamnien = $request->tuthamnien;
        $ctgdhotro->ctgdhotro_denthamnien = $request->denthamnien;
        $ctgdhotro->ctgdhotro_sotienhotro = $request->sotienhotro;
        $ctgdhotro->ctgdhotro_diengiai = $request->diengiai;
        $ctgdhotro->gd_id = $id;

        $ctgdhotro->save();
        $ctgdhotro->giaidoan->donvi;
        return response()->json($ctgdhotro);
    }

    public function update(Request $request, $id)
    {
        $chitiet = ChiTietGiaiDoanHoTro::find($id);
        if (!$chitiet)
            return response()->json(['message' => 'Khong tim thay thong tin ho tro'],400);

        if (Auth::user()->ltk_id == 2 && $chitiet->giaidoan->donvi->id != Auth::user()->dv_id)
            return response()->json(['message' => 'Khong co quyen o don vi nay'], 401);

        $chitiet->ctgdhotro_tuthamnien = $request->tuthamnien;
        $chitiet->ctgdhotro_denthamnien = $request->denthamnien;
        $chitiet->ctgdhotro_sotienhotro = $request->sotienhotro;
        $chitiet->ctgdhotro_diengiai = $request->diengiai;

        $chitiet->save();
        $chitiet->giaidoan->donvi;
        return response()->json($chitiet);
    }

    public function destroy($id)
    {
        $chitiet = ChiTietGiaiDoanHoTro::find($id);
        if (!$chitiet)
            return response()->json(['message' => 'Khong tim thay thong tin ho tro'],400);
        if (Auth::user()->ltk_id == 2 && $chitiet->giaidoan->donvi->id != Auth::user()->dv_id)
            return response()->json(['message' => 'Khong co quyen o don vi nay'],401);

        $chitiet->delete();
        return response()->json(['message' => 'Xoa thanh cong']);
    }
}
