<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email','admin@fundacion.com')->exists()) {
            User::create([
                'ci' => '00000001',
                'name' => 'Admin',
                'apellido' => 'General',
                'email' => 'admin@fundacion.com',
                'telefono' => '70000000',
                'direccion' => 'Sede Central',
                'fecha_nacimiento' => '1990-01-01',
                'fecha_ingreso' => now()->toDateString(),
                'password' => Hash::make('Admin1234'),
                'estado' => 'activo',
                'rol' => 'administrador',
            ]);
        }
    }
}
