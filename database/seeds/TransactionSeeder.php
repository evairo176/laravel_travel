<?php

use Illuminate\Database\Seeder;
use App\Transactions;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transactions::create([
            'travel_packages' => '1',
            'users_id' => '1',
            'additional_visa' => '190',
            'transaction_total' => '290',
            'transaction_status' => 'PENDING'
        ]);
    }
}
