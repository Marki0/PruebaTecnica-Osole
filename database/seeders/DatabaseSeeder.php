<?php

namespace Database\Seeders;

use App\Models\SiteSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@nikitos.test'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'home_snacks'],
            [
                'title' => 'Nikitos Snacks',
                'body' => 'Editá este texto desde el panel: presentación breve de la marca en la home.',
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'nosotros'],
            [
                'title' => 'Nosotros',
                'body' => 'Editá la historia de Nikitos y el contenido de la sección Nosotros.',
            ]
        );
    }
}
