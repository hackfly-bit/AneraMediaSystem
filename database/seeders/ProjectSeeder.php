<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'client_id' => 1,
            'name' => 'Website Development',
            'description' => 'Pengembangan website corporate untuk Tech Solutions Inc.',
            'status' => 'in_progress',
            'budget' => 50000000.00,
            'progress_percentage' => 75,
            'deadline' => '2025-02-15',
            'notes' => 'Proyek berjalan sesuai timeline'
        ]);

        Project::create([
            'client_id' => 2,
            'name' => 'Digital Marketing Campaign',
            'description' => 'Kampanye digital marketing untuk meningkatkan brand awareness.',
            'status' => 'completed',
            'budget' => 25000000.00,
            'progress_percentage' => 100,
            'deadline' => '2024-12-31',
            'notes' => 'Proyek selesai dengan hasil memuaskan'
        ]);

        Project::create([
            'client_id' => 3,
            'name' => 'Brand Identity Design',
            'description' => 'Pembuatan logo dan brand identity untuk Creative Design Studio.',
            'status' => 'draft',
            'budget' => 15000000.00,
            'progress_percentage' => 0,
            'deadline' => '2025-03-30',
            'notes' => 'Menunggu approval dari klien'
        ]);

        Project::create([
            'client_id' => 1,
            'name' => 'Mobile App Development',
            'description' => 'Pengembangan aplikasi mobile untuk Tech Solutions Inc.',
            'status' => 'in_progress',
            'budget' => 75000000.00,
            'progress_percentage' => 30,
            'deadline' => '2025-05-15',
            'notes' => 'Fase development backend sedang berlangsung'
        ]);
    }
}
