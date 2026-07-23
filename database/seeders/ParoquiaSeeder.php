<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParoquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paroquias')->insert([
            'name' => 'Paróquia São João Batista',
            'city' => 'Cedro',
        ]);

        DB::table('paroquias')->insert([
            'name' => 'Paróquia São José',
            'city' => 'Catarina',
        ]);

        DB::table('paroquias')->insert([
            'name' => 'Paróquia Imaculada Conceição',
            'city' => 'Milhã',
        ]);

        DB::table('paroquias')->insert([
            'name' => 'Paróquia Imaculada Conceição',
            'city' => 'Irapuan Pinheiro',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Perpétuo Socorro',
            'city' => 'Acopiara',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Sagrado Coração de Jesus',
            'city' => 'Piquet Carneiro',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra Do Carmo',
            'city' => 'Jucás',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra Das Dores',
            'city' => 'Senador Pompeu',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia São Sebastião',
            'city' => 'Pedra Branca',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra da Expectação',
            'city' => 'Icó',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Bom Jesus Aparecido',
            'city' => 'Solonópoles',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra Auxiliadora',
            'city' => 'Cariús',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra da Glória',
            'city' => 'Mombaça',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Perpétuo Socorro',
            'city' => 'Orós',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Perpétuo Socorro',
            'city' => 'Mineirolândia',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Perpétuo Socorro',
            'city' => 'Mombaça',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia São Francisco',
            'city' => 'Acopiara',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Bom Jesus Piedoso',
            'city' => 'Quixelô',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra das Graças',
            'city' => 'Iguatu',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Senhora Santana',
            'city' => 'Iguatu',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Sé Catedral de São José',
            'city' => 'Iguatu',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Perpétuo Socorro',
            'city' => 'Iguatu',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra da Purificação',
            'city' => 'Saboeiro',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia São Pedro Apóstolo',
            'city' => 'Jucás',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra do Rosário',
            'city' => 'Icó',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Quase Paróquia São José',
            'city' => 'Solonópoles',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N. Sra da Paz',
            'city' => 'Arneiroz',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia N Sra do Patrocínio',
            'city' => 'Aiuaba',
        ]);
        DB::table('paroquias')->insert([
            'name' => 'Paróquia Imaculada Conceição',
            'city' => 'Vila Guassussê',
        ]);
    }
}
