<?php

namespace Database\Seeders;

use App\Models\Compte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Compte::create([
            'client_id' => 1,
            'numero_compte' => bcrypt('1234567890'),
            'solde' => 1000.00,
        ]);

        Compte::create([
            'client_id' => 2,
            'numero_compte' => bcrypt('9876543210'),
            'solde' => 500.00,
        ]);

        Compte::create([
            'client_id' => 3,
            'numero_compte' => bcrypt('123456780'),
            'solde' => 800.00,
        ]);

        Compte::create([
            'client_id' => 4,
            'numero_compte' => bcrypt('876543210'),
            'solde' => 1800.00,
        ]);
    }
}
