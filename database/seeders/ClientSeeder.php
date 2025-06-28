<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'John Doe',
            'company' => 'Tech Solutions Inc.',
            'address' => 'Jl. Sudirman No. 123, Jakarta',
            'phone' => '+62 21 1234 5678',
            'email' => 'john@techsolutions.com',
            'status' => 'active'
        ]);

        Client::create([
            'name' => 'Jane Smith',
            'company' => 'Digital Marketing Pro',
            'address' => 'Jl. Thamrin No. 456, Jakarta',
            'phone' => '+62 21 8765 4321',
            'email' => 'jane@digitalmarketing.com',
            'status' => 'active'
        ]);

        Client::create([
            'name' => 'Robert Johnson',
            'company' => 'Creative Design Studio',
            'address' => 'Jl. Gatot Subroto No. 789, Jakarta',
            'phone' => '+62 21 5555 1234',
            'email' => 'robert@creativedesign.com',
            'status' => 'active'
        ]);
    }
}
