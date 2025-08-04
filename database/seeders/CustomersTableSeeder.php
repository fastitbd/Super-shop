<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('customers')->delete();
        DB::table('customers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Walk-in Customer',
                'email' => 'default@gmail.com',
                'phone' => '00000000000',
                'address' => 'Default Address',
                'open_receivable' => '0.00',
                'open_payable' => '0.00',
                'status' => '1',
                'created_at' => '2023-11-22 19:34:22',
                'updated_at' => '2023-12-02 20:14:53',
            )
        ));


    }
}
