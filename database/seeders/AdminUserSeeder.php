<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
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

        // PROFESSOR - HIAGO
        User::updateOrCreate(
            ['masp' => '100011620'],
            [
                'name' => 'Hiago Raian Gonçalves Carvalho',
                'cpf' => '08823706696',
                'email' => 'hiagoraian98@gmail.com',
                'phone' => null,
                'is_admin' => false,
                'professor_type' => 'efetivo',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
