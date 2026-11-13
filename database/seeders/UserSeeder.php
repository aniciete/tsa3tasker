<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the single canonical Tasker profile user matching TSA1.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['username' => 'charles'],
            [
                'full_name' => 'Charles Lawrence Aniciete',
                'email'     => 'charles@example.com',
            ]
        );
    }
}
