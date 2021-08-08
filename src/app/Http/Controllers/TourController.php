<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\DonVi;
use App\Models\HinhTour;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tours = Tour::paginate(16);

        foreach ($tours as $tour) {
            $tour->hinhtour;
            $tour->donvi;
            $tour->hinhtour;
        }

        if (!$tour)
            return response()->json(['message'=> 'Co loi'], 400);

        return response()->json($tours);
    }

    public function all()
    {
        $tours = Tour::all();

        foreach ($tours as $tour) {
            $tour->dangkytour;
            $tour->donvi;
            $tour->hinhtour;
        }

        return response()->json($tours);
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
    public function store(StoreTourRequest $request)
    {
        //
        $msgError = '';
        $codeErr = 200;
        $admindonvi = Auth::user()->ltk_id == 2;
        $tour = new Tour;

        if (!$request->dv_id && $admindonvi)
            $tour->dv_id = Auth::user()->dv_id;

        if ($request->dv_id) {
            if (Auth::user()->ltk_id == 1 && DonVi::find($request->dv_id))
                $tour->dv_id = $request->dv_id;

            if (!DonVi::find($request->dv_id)){
                $msgError = 'Don vi khong ton tai';
                $codeErr=400;
            }
            if ($admindonvi && $request->dv_id != Auth::user()->dv_id){
                $msgError = 'Khong co quyen them tour vao don vi nay';
                $codeErr= 401;
            }
            else $tour->dv_id = $request->dv_id;
        }

        if ($msgError == '') {
            $tour->fill($request->except(['images', 'dv_id']));

            $tour->save();

            if ($request->images && $request->images != null){
                // $images = json_decode($request->images);
                $images = $request->images;
                // return $images;
                foreach ($images as $file) {
                    $name = rand(0000000, 9999999) . '.' . $file->getClientOriginalExtension();
                    $pathPic = public_path('/storage/images/') . $name;
                    while (Storage::exists($pathPic)) {
                        $name = rand(0000000, 9999999) . '.' . $file->getClientOriginalExtension();
                        $pathPic = public_path('/storage/images/') . $name;
                    }
                    $file->move(public_path('/storage/images/'), $name);
                    $picAdd = new HinhTour;
                    $picAdd->t_id = $tour->id;
                    $picAdd->ht_path = $pathPic;
                    $picAdd->save();
                }
                $tour->hinhtour;
            }
            $msgError = 'Them tour thanh cong';
        }

        return response()->json(['message' => $msgError, 'tour' => $tour],$codeErr);
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
        $tour = Tour::find($id);

        if (!$tour){
            $msgError = 'Khong tim thay tour ' . $id;
            $codeErr = 400;
        }
        if ($msgError == '') {
            $tour->donvi;
            $tour->hinhtour;
            $msgError = 'Thanh cong';
        }

        return response()->json(['message' => $msgError, 'tour' => $tour],$codeErr);
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
    public function update(UpdateTourRequest $request, $id)
    {
        //
        $msgError = '';
        $codeErr = 200;
        $tour = Tour::find($id);
        if (Auth::user()->ltk_id == 2 && $tour->donvi->id != Auth::user()->dv_id)
            return response()->json(['message' => 'Khong co quyen thao tac tren tour cua don vi nay'],401);

        if (Auth::user()->ltk_id == 1){
            $tour->dv_id = $request->dv_id;
        }


        if (!$tour){
            $msgError =  'Khong tim thay tour ' . $id;
            $codeErr = 400;
        }
        if ($msgError == '') {
            $tour->fill($request->except('dv_id'))->save();
            $msgError = 'Sua thanh cong tour ' . $id;
        }

        return response()->json(['message' => $msgError, 'tour' => $tour],$codeErr);
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
        $admindonvi = Auth::user()->ltk_id == 2;
        $tour = Tour::find($id);

        if (!$tour)
            return response()->json(['message' =>  'Tour khong ton tai'], 400);

        $donvi = $tour->dv_id == Auth::user()->dv_id;
        if ($admindonvi && !$donvi){
            $msgError =  'Khong co quyen thao tac tren tour cua don vi nay';
            $codeErr = 401;
        }
        if ($msgError == '') {
            $tour->delete();
            $msgError = 'Xoa thanh cong tour ' . $id;
        }

        return response()->json(['message' =>  $msgError],$codeErr);
    }

    public function restore($id)
    {
        //
        $msgError = '';
        $codeErr = 200;

        $tour = Tour::onlyTrashed()->find($id);

        if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != $tour->donvi->id){
            $msgError = 'Khong co quyen thao tac tren tour cua don vi nay';
            $codeErr = 401;
        }
        if (!$tour) {
            $msgError = 'Tour khong bi xoa';
            $codeErr = 400;
        }

        if (Auth::user()->ltk_id == 1 || $msgError == '') {
            $tour->restore();
            $msgError = 'Khoi phuc thanh cong tour ' . $id;
        }

        return response()->json(['message' => $msgError], $codeErr);
    }

    public function history()
    {
        //
        $idDV = Auth::user()->dv_id;
        if (Auth::user()->ltk_id == 2){
            $tour = Tour::onlyTrashed()->where('dv_id', '=', $idDV)->get();
            foreach ($tour as $item) {
                $item->donvi;
                $item->dangkytour;
            }
            return response()->json(['message' => 'Thanh cong', 'tour' => $tour]);
        }
        if (Auth::user()->ltk_id == 1){
            $tour = Tour::onlyTrashed()->get();
            foreach ($tour as $item) {
                $item->donvi;
                $item->dangkytour;
            }
            return response()->json(['message' => 'Thanh cong', 'tour' => $tour]);
        }
        
    }

    public function addpic(Request $request, $idTour)
    {
        //
        if ($request->images && $request->images != null && $request->images != '' && count($request->images) != 0){
            $tour =Tour::find($idTour);

            if (Auth::user()->ltk_id == 2 && $tour->donvi->id != Auth::user()->dv_id)
                return response()->json(['message' => 'Khong co quyen thao tac tren tour cua don vi nay'],401);

            if (!$tour){
                return response()->json(['message' =>'Tour khong ton tai'],400);  
            }
            
            $imgs = $request->images;
            $pics = $tour->hinhtour;
            foreach ($pics as $hinh) {
                File::delete($hinh->ht_path);
                $hinh->delete();
            }

            foreach ($imgs as $img){
                $name = rand(0000000, 9999999) . '.' . $img->getClientOriginalExtension();
                $pathPic = public_path('/storage/images/') . $name;

                $img->move(public_path('/storage/images/'), $name);
                $hinhtour = new HinhTour;
                $hinhtour->t_id = $idTour;
                $hinhtour->ht_path = $pathPic;
                $hinhtour->save();
            }
            
            return response()->json(['message' => 'Thanh cong'],200);
        } 
        return response()->json(['message' => $request->images],200);
    }

    public function updatepic(Request $request, $idTour, $idPic)
    {
        //
        $msgError = '';
        $codeErr = 200;
        if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != Tour::find($idTour)->donvi->id)
            return response()->json(['message' => 'Khong co quyen thao tac tren tour cua don vi nay'],401);

        $getPic = Tour::find($idTour)->hinhtour->find($idPic);

        $nameWithEx = basename(Storage::url(($getPic->ht_path)));
        $name = explode('.', $nameWithEx)[0];
        $img = $request->file('image');

        if (!$getPic){
            $msgError = 'Hinh hoac tour khong ton tai';
            $codeErr= 400;
        }

        if ($msgError == '') {
            File::delete($getPic->ht_path);
            $img->move(public_path('/storage/images/'), $name . '.' . $img->getClientOriginalExtension());
            $getPic->ht_path = public_path('/storage/images/') . $name . '.' . $img->getClientOriginalExtension();
            $getPic->save();
            $msgError = 'Edit thanh cong hinh ' . $idPic . ' tour ' . $idTour;
        }
        return response()->json(['message' => $msgError], $codeErr);
    }

    public function destroypic($idTour, $idPic)
    {
        $msgError = '';
        $codeErr = 200;
        if (Auth::user()->ltk_id == 2 && Auth::user()->dv_id != Tour::find($idTour)->donvi->id)
            return response()->json(['message' => 'Khong co quyen thao tac tren tour cua don vi nay'], 401);

        $getPic = Tour::find($idTour)->hinhtour->find($idPic);
        if (!$getPic){
            $msgError = 'Khong tim thay hinh hoac tour';
            $codeErr = 400;
        }

        if ($msgError == '') {
            File::delete($getPic->ht_path);
            $getPic->delete();
            $msgError = 'Xoa thanh cong';
        }

        return response()->json(['message' => $msgError],$codeErr);
    }
}
