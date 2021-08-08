<?php

use App\Models\DonVi;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User;
        $user->ltk_id = 1;
        $user->nv_ten = 'Admin';
        $user->nv_namsinh = '1999';
        $user->nv_gioitinh = 'M';
        $user->nv_thoigianvaolam = '2000-01-01';
        $user->username = 'admin';
        // $pass = 'admin123';
        $user->password = Hash::make('123456');
        $user->dv_id = '99';
        $user->save();
    }
}
