<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $ranks = [
            [
                'name'        => 'BEGINNER',
                'label'       => 'Principiante',
                'description' => 'Das tus primeros pasos en el reciclaje. ¡Bienvenido!',
                'badge_color' => '#6b7c6d',
                'badge_icon'  => '🌱',
                'min_points'  => 0,
                'max_points'  => 199,
                'order'       => 1,
            ],
            [
                'name'        => 'INTERMEDIATE',
                'label'       => 'Intermedio',
                'description' => 'Ya tienes hábitos de reciclaje consolidados. ¡Sigue así!',
                'badge_color' => '#2d6a4f',
                'badge_icon'  => '♻️',
                'min_points'  => 200,
                'max_points'  => 599,
                'order'       => 2,
            ],
            [
                'name'        => 'ADVANCED',
                'label'       => 'Avanzado',
                'description' => 'Eres un referente del reciclaje en tu comunidad.',
                'badge_color' => '#1d6a8a',
                'badge_icon'  => '🌍',
                'min_points'  => 600,
                'max_points'  => 1499,
                'order'       => 3,
            ],
            [
                'name'        => 'EXPERT',
                'label'       => 'Experto',
                'description' => 'Nivel máximo. Tu impacto medioambiental es extraordinario.',
                'badge_color' => '#7e22ce',
                'badge_icon'  => '🏆',
                'min_points'  => 1500,
                'max_points'  => 0,
                'order'       => 4,
            ],
        ];

        foreach ($ranks as $rank) {
            DB::table('ranks')->updateOrInsert(['name' => $rank['name']], array_merge($rank, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
