<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ParoquiaSeeder::class,
            AdminSeeder::class,
        ]);

        if ($this->isDevelopment()) {
            $this->call([
                DevSeeder::class,
            ]);
        }
    }

    private function isDevelopment(): bool
    {
        return app()->environment('local', 'development');
    }
}
