<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('brands')->delete();
        DB::table('brands')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Default Brand',
                'slug' => 'default_brand',
                'created_at' => '2023-12-02 20:07:48',
                'updated_at' => '2023-12-02 20:12:06',
            ),
        ));


    }
}
