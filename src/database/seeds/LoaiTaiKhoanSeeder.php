<?php

use App\Models\LoaiTaiKhoan;
use Illuminate\Database\Seeder;

class LoaiTaiKhoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ltk1 = new LoaiTaiKhoan;
        $ltk1->ltk_ten = 'admin';
        $ltk2 = new LoaiTaiKhoan;
        $ltk2->ltk_ten = 'donvi';
        $ltk3 = new LoaiTaiKhoan;
        $ltk3->ltk_ten = 'nhanvien';

        $ltk1->save();
        $ltk2->save();
        $ltk3->save();
    }
}
