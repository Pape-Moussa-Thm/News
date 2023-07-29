<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'compte_id' => 1,
            'type' => 'Orange Money',
            'montant' => 50.00,
        ]);

        Transaction::create([
            'compte_id' => 2,
            'type' => 'Wave',
            'montant' => 25.00,
        ]);
        Transaction::create([
            'compte_id' => 3,
            'type' => 'Wari',
            'montant' => 25.50,
        ]);
        Transaction::create([
            'compte_id' => 4,
            'type' => 'CB',
            'montant' => 25.10,
        ]);
    }
}
