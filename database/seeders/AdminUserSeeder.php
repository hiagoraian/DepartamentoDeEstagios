<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['masp' => '100011'],
            [
                'name' => 'Departamento de Estagios',
                'cpf' => '11111111111',
                'email' => 'admin@depe.local',
                'phone' => '38 32298236',
                'is_admin' => true,
                'professor_type' => 'efetivo',
                'password' => Hash::make('depe8236'),
            ]
        );
    }
}
