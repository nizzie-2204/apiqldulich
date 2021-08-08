<?php

use App\Http\Controllers\DonViController;
use App\Http\Controllers\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//

Route::post('login', 'NhanVienController@login')->name('login');
Route::get('/tour', 'TourController@index')->name('tour.index');
Route::get('/tourall', 'TourController@all')->name('tour.all');
Route::get('/tour/{tour}', 'TourController@show')->name('tour.show');

Route::group(
    ['prefix' => '/', 'middleware' => ['auth:api']],
    function () {
        Route::post('logout', 'NhanVienController@logout')->name('logout');

        Route::prefix('nhanvien')->group(function () {
            Route::get('/', 'NhanVienController@index')->name('nhanvien.index');
            Route::put('/', 'NhanVienController@update')->name('nhanvien.update');
        });
        Route::prefix('dangkytour')->group(function () {
            Route::get('/', 'DangKyTourController@index')->name('dangkytour.index');
            Route::post('/', 'DangKyTourController@store')->name('dangkytour.store');
            Route::delete('/{dangkytour}', 'DangKyTourController@destroy')->name('dangkytour.destroy');
            Route::get('/tienhotro', 'DangKyTourController@hotro')->name('dangkytour.hotro');
        });
    }
);

Route::group(
    ['prefix' => 'admin', 'middleware' => ['auth:api', 'admin']],
    function () {
        Route::prefix('nhanvien')->group(function () {
            Route::get('/', 'NhanVienController@all')->name('nhanvien.all');
            Route::get('/{nhanvien}', 'NhanVienController@show')->name('nhanvien.show');
            Route::put('/{nhanvien}', 'NhanVienController@edit')->name('nhanvien.edit');
            Route::delete('/{nhanvien}', 'NhanVienController@destroy')->name('nhanvien.destroy');
            Route::post('/', 'NhanVienController@store')->name('nhanvien.store');
        });

        Route::prefix('tour')->group(function () {
            Route::post('/', 'TourController@store')->name('tour.store');
            Route::delete('/{tour}', 'TourController@destroy')->name('tour.destroy');
            Route::put('/{tour}', 'TourController@update')->name('tour.update');
            Route::post('/{tour}/', 'TourController@addpic')->name('tour.addpic');
            Route::delete('/{tour}/{pic}', 'TourController@destroypic')->name('tour.destroypic');
            Route::post('/{tour}/{pic}', 'TourController@updatepic')->name('tour.updatepic');
        });

        Route::prefix('donvi')->group(function () {
            Route::get('/kinhphi', 'KinhPhiController@index')->name('kinhphi.index');
            Route::post('/kinhphi/{giaidoan}', 'KinhPhiController@store')->name('kinhphi.store');
            Route::put('/kinhphi/{kinhphi}', 'KinhPhiController@update')->name('kinhphi.update');
            Route::delete('/kinhphi/{kinhphi}', 'KinhPhiController@destroy')->name('kinhphi.destroy');
            Route::get('/dangkytour', 'DangKyTourController@all')->name('dangkytour.all');
            Route::get('/giaidoan', 'GiaiDoanController@index')->name('giaidoan.index');
            Route::post('/giaidoan', 'GiaiDoanController@store')->name('giaidoan.store');
            Route::put('/giaidoan/{giaidoan}', 'GiaiDoanController@update')->name('giaidoan.update');
            Route::delete('/giaidoan/{giaidoan}', 'GiaiDoanController@destroy')->name('giaidoan.destroy');
        });

        Route::prefix('history')->group(function () {
            Route::get('/nhanvien', 'NhanVienController@history')->name('history.nhanvien');
            Route::get('/tour', 'TourController@history')->name('history.tour');
            Route::put('/tour/{tour}/restore', 'TourController@restore')->name('history.tour.restore');
            Route::put('/nhanvien/{nhanvien}/restore', 'NhanVienController@restore')->name('history.nhanvien.restore');
            Route::get('donvi', 'DonViController@history')->name('history.donvi')->middleware('adminsystem');
            Route::put('donvi/{donvi}/restore', 'DonViController@restore')->name('restore.donvi')->middleware('adminsystem');
        });
    }
);

Route::group(
    ['prefix' => 'adminsystem', 'middleware' => ['auth:api', 'adminsystem']],
    function () {
        Route::prefix('donvi')->group(function () {
            Route::get('/', 'DonViController@index')->name('donvi.index');
            Route::get('/{donvi}', 'DonViController@show')->name('donvi.show');
            Route::post('/', 'DonViController@store')->name('donvi.store');
            Route::put('/{donvi}', 'DonViController@update')->name('donvi.update');
            Route::delete('/{donvi}', 'DonViController@destroy')->name('donvi.destroy');
        });
    }
);
