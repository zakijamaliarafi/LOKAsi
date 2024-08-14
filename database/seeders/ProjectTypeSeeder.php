<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'project_type' => 'POI Collection',
            ],
            [
                'project_type' => 'PA Collection',
            ],
            [
                'project_type' => 'Road Makker',
            ],
            [
                'project_type' => 'Drone Mapping',
            ],
            [
                'project_type' => 'Survey',
            ],
            [
                'project_type' => 'Desain Taman',
            ],
            [
                'project_type' => 'Desain Landscape Area',
            ],
            [
                'project_type' => 'Desain Bangunan/Architecture',
            ],
            [
                'project_type' => 'Perencanaan Kebun',
            ],
            [
                'project_type' => 'Analisis & Evaluasi Kebun',
            ],
            [
                'project_type' => 'Inventarisasi Aset Tanaman',
            ],
            [
                'project_type' => 'Masterplan Kebun (Produksi / Agrowisata)',
            ],
            [
                'project_type' => 'GIS Training',
            ],
            [
                'project_type' => 'Drone Mapping',
            ],
            [
                'project_type' => 'Survey & Navigation',
            ],
            [
                'project_type' => 'Workshop',
            ],
            [
                'project_type' => 'LOKAsi Project',
            ],
            [
                'project_type' => 'Company Web Development',
            ],
            [
                'project_type' => 'Business Web Development',
            ],
            [
                'project_type' => 'SMARTpodes',
            ],
            [
                'project_type' => 'SIGAPdesa',
            ],
            [
                'project_type' => 'LOKAsi Platform',
            ],
            [
                'project_type' => 'Business Platform',
            ],
            [
                'project_type' => 'Comercial Platform',
            ],
        ];

        foreach ($types as $type) {
            ProjectType::create($type);
        }
    }
}
