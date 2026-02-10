<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            // Norte de Minas (lista inicial – podemos ampliar depois)
            ['name' => 'Montes Claros'],
            ['name' => 'Janaúba'],
            ['name' => 'Januária'],
            ['name' => 'Pirapora'],
            ['name' => 'Bocaiúva'],
            ['name' => 'Salinas'],
            ['name' => 'Taiobeiras'],
            ['name' => 'Porteirinha'],
            ['name' => 'Espinosa'],
            ['name' => 'São Francisco'],
            ['name' => 'Brasília de Minas'],
            ['name' => 'São João da Ponte'],
            ['name' => 'Francisco Sá'],
            ['name' => 'Coração de Jesus'],
            ['name' => 'Buritizeiro'],
            ['name' => 'Várzea da Palma'],
            ['name' => 'Grão Mogol'],
            ['name' => 'Capitão Enéas'],
            ['name' => 'Jaíba'],
            ['name' => 'Manga'],
            ['name' => 'Matias Cardoso'],
            ['name' => 'Itacarambi'],
            ['name' => 'Mirabela'],
            ['name' => 'Lontra'],
            ['name' => 'Varzelândia'],
            ['name' => 'São Romão'],
            ['name' => 'Ibiaí'],
            ['name' => 'Patis'],
            ['name' => 'Rubelita'],
            ['name' => 'Rio Pardo de Minas'],
            ['name' => 'Berizal'],
            ['name' => 'Indaiabira'],
            ['name' => 'Novorizonte'],
            ['name' => 'Vargem Grande do Rio Pardo'],
            ['name' => 'Padre Carvalho'],
            ['name' => 'Japonvar'],
            ['name' => 'Ubaí'],
            ['name' => 'Icaraí de Minas'],
            ['name' => 'Santa Fé de Minas'],
            ['name' => 'Pintópolis'],
            ['name' => 'Urucuia'],
            ['name' => 'Chapada Gaúcha'],
            ['name' => 'Montalvânia'],
            ['name' => 'Bonito de Minas'],
            ['name' => 'Pedras de Maria da Cruz'],
            ['name' => 'Campo Azul'],
            ['name' => 'Verdelândia'],
            ['name' => 'Gameleiras'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['name' => $city['name'], 'uf' => 'MG'],
                ['ibge_code' => null]
            );
        }
    }
}
