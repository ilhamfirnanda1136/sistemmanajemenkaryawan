<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB,Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Users')->insert([
            'name' => 'ilham HRD',
            'username' => 'hrdperusahaan',
            'password' => Hash::make('hrdperusahaan'),
            'email'=> 'hrdperusahaan@gmail.com',
            'level' => 'hrd'
        ]);
        DB::table('Users')->insert([
            'name' => 'Atasan Perusahaan',
            'username' => 'atasanperusahaan',
            'password' => Hash::make('atasanperusahaan'),
            'email'=> 'atasanperusahaan@gmail.com',
            'level' => 'atasan'
        ]);
    }
}
