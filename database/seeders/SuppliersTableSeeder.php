<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('suppliers')->delete();
        DB::table('suppliers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Walk-in Supplier',
                'email' => 'default@gmail.com',
                'phone' => '000000000000',
                'address' => 'Bonosree,Dhaka.',
                'open_receivable' => '0.00',
                'open_payable' => '0.00',
                'status' => '1',
                'created_at' => '2023-11-22 20:29:26',
                'updated_at' => '2023-12-01 16:57:40',
            )
        ));


    }
}
