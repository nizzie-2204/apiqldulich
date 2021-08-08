<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonViRequest;
use App\Models\DonVi;
use Illuminate\Http\Request;

class DonViController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $donvi = DonVi::all();
        return response()->json($donvi);
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
    public function store(Request $request)
    {
        //
        if ($request->dv_ten == ''){
            return response()->json(['message'=>'Ten don vi khong duoc de trong'],400);
        }
        $donvi = new DonVi;
        $donvi->fill($request->all());
        $donvi->save();

        return response()->json(['message' => 'Them don vi thanh cong', 'donvi' => $donvi]);
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
        $msgError = '';
        $codeErr = 200;
        $donvi = DonVi::find($id);
        if(!$donvi){
            $msgError = 'Khong tim thay don vi';
            $codeErr = 400;
        } else $msgError = 'Thanh cong';

        return response()->json(['message' => $msgError, 'donvi' => $donvi],$codeErr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $msgError = '';
        $codeErr = 200;
        $donvi = DonVi::find($id);

        if ($donvi) {
            $donvi->fill($request->all());
            $donvi->save();
            $msgError = 'Thay doi thanh cong don vi ' . $id;
        } else{
            $msgError = 'Khong tim thay don vi ';
            $codeErr = 400;
        }
        return response()->json(['message' => $msgError, 'donvi' => $donvi],$codeErr);
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

        $donvi = DonVi::find($id);
        if ($donvi) {
            $donvi->delete();
            $msgError = 'Xoa thanh cong don vi ' . $id;
        } else {
        $msgError = 'Khong tim thay don vi' . $id;
        $codeErr = 400;
        }
        return response()->json(['message' => $msgError],$codeErr);
    }

    public function history()
    {
        $donvi = DonVi::onlyTrashed()->get();
        return response()->json(['message' => 'Thanh cong', 'donvi' => $donvi]);
    }

    public function restore($id)
    {
        $msgError = '';
        $codeErr = 200;
        $donvi = DonVi::onlyTrashed()->find($id);
        if ($donvi) {
            $donvi->restore();
            $msgError = 'Khoi phuc thanh cong don vi ' . $id;
        } else {
            $msgError = 'Don vi ' . $id . ' khong bi xoa';
            $codeErr = 400;
        }
        return response()->json(['message' => $msgError],$codeErr);
    }
}
