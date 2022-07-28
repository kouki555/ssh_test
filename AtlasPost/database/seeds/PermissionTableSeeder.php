<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => '晃暉',
            'email' => 'kouki5555@gmail.com',
            'password' => bcrypt('dawn2'),
            'admin_role' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
