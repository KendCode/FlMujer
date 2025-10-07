<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormasViolenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        $items = [
            'Pellizcos','Patadas','Empujones','Arañazos','Mordiscos','Puñetes','Tirones de cabello',
            'Fracturas','Quemaduras','Golpes con objetos','Agresiones con arma blanca','Asfixia',
            'Insultos','Humillaciones','Amenazas de muerte','Acoso sexual','Violación','Intento de violación'
        ];

        foreach ($items as $name) {
            DB::table('formas_violencia')->updateOrInsert(['nombre' => $name]);
        }
    }
}
