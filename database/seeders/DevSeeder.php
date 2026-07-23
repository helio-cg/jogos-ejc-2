<?php

namespace Database\Seeders;

use App\Models\Atleta;
use App\Models\User;
use App\Models\UserModalidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $this->criarPai1ComSubUsuarios();
        $this->criarPai2ComSubUsuarios();
        $this->criarPai3SemSubUsuarios();
    }

    private function criarPai1ComSubUsuarios(): void
    {
        $pai = User::firstOrCreate(
            ['email' => 'pai1@email.com'],
            [
                'name' => 'Carlos Eduardo (Pai 1)',
                'password' => Hash::make('password'),
                'active' => true,
                'status' => 'completo',
                'role' => 'parent',
                'paroquia_id' => 1,
                'whatsapp' => '(88) 99999-0001',
            ]
        );

        $subUsersData = [
            ['name' => 'Ana Souza (Sub 1 - Futsal)', 'email' => 'sub1@email.com', 'modalidade' => 'Futsal'],
            ['name' => 'Bruno Lima (Sub 2 - Vôlei)', 'email' => 'sub2@email.com', 'modalidade' => 'Vôlei'],
            ['name' => 'Camila Ferreira (Sub 3 - Queimada)', 'email' => 'sub3@email.com', 'modalidade' => 'Queimada'],
        ];

        foreach ($subUsersData as $data) {
            $modalidade = $data['modalidade'];
            unset($data['modalidade']);

            $sub = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('password'),
                    'active' => true,
                    'status' => 'incompleto',
                    'role' => 'sub_user',
                    'parent_id' => $pai->id,
                    'paroquia_id' => $pai->paroquia_id,
                ])
            );

            UserModalidade::firstOrCreate(
                ['user_id' => $sub->id],
                ['modalidade' => $modalidade]
            );
        }

        $this->criarAtletasParaPai($pai);
        $this->criarAtletasParaSubUsers($pai);
    }

    private function criarPai2ComSubUsuarios(): void
    {
        $pai = User::firstOrCreate(
            ['email' => 'pai2@email.com'],
            [
                'name' => 'Maria Oliveira (Pai 2)',
                'password' => Hash::make('password'),
                'active' => true,
                'status' => 'incompleto',
                'role' => 'parent',
                'paroquia_id' => 3,
                'whatsapp' => '(88) 99999-0002',
            ]
        );

        $sub = User::firstOrCreate(
            ['email' => 'sub4@email.com'],
            [
                'name' => 'Pedro Alves (Sub 4 - Vôlei)',
                'password' => Hash::make('password'),
                'active' => true,
                'status' => 'incompleto',
                'role' => 'sub_user',
                'parent_id' => $pai->id,
                'paroquia_id' => $pai->paroquia_id,
            ]
        );

        UserModalidade::firstOrCreate(
            ['user_id' => $sub->id],
            ['modalidade' => 'Vôlei']
        );

        $nomesAtletas = [
            ['nome' => 'Lucas Mendes', 'conhecido_como' => 'Luca', 'modalidade' => ['Vôlei'], 'pagamento' => true],
            ['nome' => 'Fernanda Costa', 'conhecido_como' => null, 'modalidade' => ['Queimada'], 'pagamento' => false],
            ['nome' => 'Rafael Santos', 'conhecido_como' => 'Rafa', 'modalidade' => ['Futsal'], 'pagamento' => true],
        ];

        foreach ($nomesAtletas as $atleta) {
            Atleta::create([
                'nome' => $atleta['nome'],
                'conhecido_como' => $atleta['conhecido_como'],
                'data_nascimento' => fake()->dateTimeBetween('-25 years', '-18 years'),
                'modalidade' => $atleta['modalidade'],
                'pagamento' => $atleta['pagamento'],
                'user_id' => $pai->id,
            ]);
        }

        Atleta::create([
            'nome' => 'Gabriel Pereira',
            'conhecido_como' => 'Gabi',
            'data_nascimento' => fake()->dateTimeBetween('-22 years', '-18 years'),
            'modalidade' => ['Vôlei'],
            'pagamento' => false,
            'user_id' => $sub->id,
        ]);
    }

    private function criarPai3SemSubUsuarios(): void
    {
        User::firstOrCreate(
            ['email' => 'pai3@email.com'],
            [
                'name' => 'José Silva (Pai 3 - Sem Sub)',
                'password' => Hash::make('password'),
                'active' => true,
                'status' => 'incompleto',
                'role' => 'parent',
                'paroquia_id' => 5,
                'whatsapp' => '(88) 99999-0003',
            ]
        );
    }

    private function criarAtletasParaPai(User $pai): void
    {
        $atletas = [
            ['nome' => 'Marcos Vinícius', 'conhecido_como' => 'Marcão', 'modalidade' => ['Futsal'], 'pagamento' => true],
            ['nome' => 'Thiago Almeida', 'conhecido_como' => null, 'modalidade' => ['Futsal'], 'pagamento' => true],
            ['nome' => 'Diego Nascimento', 'conhecido_como' => 'Didi', 'modalidade' => ['Queimada'], 'pagamento' => false],
            ['nome' => 'Bruno Carvalho', 'conhecido_como' => null, 'modalidade' => ['Futsal'], 'pagamento' => false],
            ['nome' => 'Leonardo Reis', 'conhecido_como' => 'Leo', 'modalidade' => ['Vôlei'], 'pagamento' => true],
        ];

        foreach ($atletas as $atleta) {
            Atleta::create([
                'nome' => $atleta['nome'],
                'conhecido_como' => $atleta['conhecido_como'],
                'data_nascimento' => fake()->dateTimeBetween('-25 years', '-18 years'),
                'modalidade' => $atleta['modalidade'],
                'pagamento' => $atleta['pagamento'],
                'user_id' => $pai->id,
            ]);
        }
    }

    private function criarAtletasParaSubUsers(User $pai): void
    {
        $subUsers = $pai->children()->with('userModalidades')->get();

        $atletasPorSub = [
            0 => [
                ['nome' => 'Ricardo Martins', 'conhecido_como' => 'Ricardão', 'modalidade' => ['Futsal'], 'pagamento' => true],
                ['nome' => 'Alexandre Dias', 'conhecido_como' => null, 'modalidade' => ['Futsal'], 'pagamento' => false],
            ],
            1 => [
                ['nome' => 'Felipe Araújo', 'conhecido_como' => 'Felipão', 'modalidade' => ['Vôlei'], 'pagamento' => true],
                ['nome' => 'Gustavo Ribeiro', 'conhecido_como' => 'Guto', 'modalidade' => ['Vôlei'], 'pagamento' => false],
            ],
            2 => [
                ['nome' => 'Ian Campos', 'conhecido_como' => null, 'modalidade' => ['Queimada'], 'pagamento' => false],
                ['nome' => 'Jorge Menezes', 'conhecido_como' => 'Jorginho', 'modalidade' => ['Queimada'], 'pagamento' => true],
            ],
        ];

        foreach ($subUsers as $index => $sub) {
            $atletas = $atletasPorSub[$index] ?? [];
            foreach ($atletas as $atleta) {
                Atleta::create([
                    'nome' => $atleta['nome'],
                    'conhecido_como' => $atleta['conhecido_como'],
                    'data_nascimento' => fake()->dateTimeBetween('-24 years', '-18 years'),
                    'modalidade' => $atleta['modalidade'],
                    'pagamento' => $atleta['pagamento'],
                    'user_id' => $sub->id,
                ]);
            }
        }
    }
}
