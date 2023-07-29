<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'nom' => 'Diallo',
            'prenom' => 'Khawsou',
            'email' => 'client1@example.com',
            'telephone' => '1234567890',
        ]);

        Client::create([
            'nom' => 'Bachir',
            'prenom' => 'Mouhamed',
            'email' => 'client2@example.com',
            'telephone' => '9876543210',
        ]);

        Client::create([
            'nom' => 'Sagna',
            'prenom' => 'Moussa',
            'email' => 'client3@example.com',
            'telephone' => '123456780',
        ]);

        Client::create([
            'nom' => 'Mané',
            'prenom' => 'Adama',
            'email' => 'client4@example.com',
            'telephone' => '876543210',
        ]);
    }
}
