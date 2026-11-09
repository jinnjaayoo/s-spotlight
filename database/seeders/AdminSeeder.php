<?php

namespace Database\Seeders;

use App\Models\Loginadmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Loginadmin::firstOrCreate(
            ['email' => 'admin@sspotlight.test'],
            [
                'name' => 'Admin S\'Spotlight',
                'password' => Hash::make('orangpenting'),
                'keterangan' => 'Administrator utama S\'Spotlight — mengelola portofolio, galeri, dan info umum SMKN 2 Purwakarta.',
            ]
        );
    }
}
