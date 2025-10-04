<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carousel;
class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Carousel::create([
            'titulo' => 'Bienvenida FLM',
            'descripcion' => 'Fundación Levántate Mujer',
            'imagen' => 'banner1.png',
            'orden' => 0
        ]);
        Carousel::create([
            'titulo' => 'Empoderamiento',
            'descripcion' => 'Apoyo psicológico y legal',
            'imagen' => 'banner2.jpeg',
            'orden' => 1
        ]);
        Carousel::create([
            'titulo' => 'Comunidad',
            'descripcion' => 'Talleres y eventos comunitarios',
            'imagen' => 'banner3.jpeg',
            'orden' => 2
        ]);
    }
}
