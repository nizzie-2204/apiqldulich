<?php

namespace App\Http\Controllers;

use App\Http\Requests\DangKyTourRequest;
use App\Http\Requests\StoreDangKyTourRequest;
use App\Models\DangKyTour;
use App\Models\GiaiDoanHoTro;
use App\Models\NhanVienNhanHoTroTour;
use App\Models\Tour;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DangKyTourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $dangkys = Auth::user()->dangkytour;

        $dangkys->sortBy('id');
        foreach ($dangkys as $dangky) {
            $dangky->user;
            $dangky->tour;
        }

        return response()->json(['message' => 'Thanh cong', 'dangky' => $dangkys]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDangKyTourRequest $request)
    {
        //
        $msgError = '';

        $nv = Auth::user();
        $tour = Tour::find($request->t_id);

        if (!$tour)
            return response()->json(['message' => 'Tour khong ton tai'], 400);

        // if ($nv->dv_id != $tour->dv_id)
        //     return response()->json(['message' => 'Tour nay khong nam trong don vi cua ban'], 401);

        $now = Carbon::now();
        if ($now >= $tour->t_tgketthucdk)
            return response()->json(['message' => 'Da ket thuc dang ky'], 400);

        $gdhotro = GiaiDoanHoTro::whereRaw('gd_tunam <= ? and ? <= gd_dennam and dv_id = ?', array(now()->year, now()->year, $nv->dv_id))->get();
        $checkDaHoTro = NhanVienNhanHoTroTour::whereRaw('nv_id = ? and gd_id = ?',array($nv->id,$gdhotro[0]->id))->get();
        if (count($gdhotro) > 0 && count($checkDaHoTro) <= 0) {
            $nhanhotro = new NhanVienNhanHoTroTour;
            $nhanhotro->gd_id = $gdhotro[0]->id;
            $nhanhotro->nv_id = $nv->id;
            $nhanhotro->t_id = $request->t_id;
            $nhanhotro->save();
        }

        $dangky = new DangKyTour;
        if ($msgError == '') {
            $dangky->fill($request->all());

            $dangky->nv_id = $nv->id;
            $dangky->save();
            $msgError = 'Dang ky thanh cong';
        }

        return response()->json(['message' => $msgError, 'dangky' => $dangky]);
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

        $msgError = '';
        $codeErr = 200;
        $dangky = Auth::user()->dangkytour->find($id);

        if (!$dangky){
            $codeErr = 400;
            $msgError = 'Khong tim thay dang ky' ;
        }

        if ($msgError == '') {
            $dangky->delete();
            $msgError = 'Da huy dang ky';
        }

        return response()->json(['message' => $msgError],$codeErr);
    }

    public function all()
    {
        $dangkytours = DangKyTour::with(['tour', 'user'])->get();

        return response()->json($dangkytours);
    }

    public function hotro()
    {
        $nv = Auth::user();
        $thamnien = now()->year - Carbon::createFromFormat('Y-m-d', $nv->nv_thoigianvaolam)->year;
        $sotienhotro = 0;

        $gdhotro = GiaiDoanHoTro::whereRaw('gd_tunam <= ? and ? <= gd_dennam and dv_id = ?', array(now()->year, now()->year, $nv->dv_id))->get();
        if (count($gdhotro) > 0) {
            $chitiets = $gdhotro[0]->chitiet;
            foreach ($chitiets as $chitiet) {
                if ($chitiet->ctgdhotro_tuthamnien <= $thamnien && $thamnien <= $chitiet->ctgdhotro_denthamnien) {
                    $sotienhotro = $chitiet->ctgdhotro_sotienhotro;
                }
            }
        }
        $checkDaHoTro = NhanVienNhanHoTroTour::whereRaw('nv_id = ? and gd_id = ?',array($nv->id,$gdhotro[0]->id))->get();

        if(count($checkDaHoTro) > 0)
            $sotienhotro = 0;

        return response()->json(['sotienhotro' => $sotienhotro]);
    }
}
