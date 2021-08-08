<?php

use Illuminate\Database\Seeder;
use App\Models\Tour;
class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 2; $i <= 20 ; $i++){
            $tour = new Tour;
            $tour->t_ten = 'Tour thu ' .$i;
            $tour->t_soluong = $i;
            $tour->t_mota = 'Mo ta tour thu '.$i;
            $tour->t_tgbatdaudk = '2020-03-10';
            $tour->t_tgketthucdk = '2020-03-10';
            $tour->t_ngaybatdau = '2020-03-10';
            $tour->t_ngayketthuc = '2020-03-10';
            $tour->t_gia= 10000 + $i;
            $tour->dv_id = 1;
            $tour->save();
        }
    }
}
