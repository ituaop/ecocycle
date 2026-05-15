<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AchievementsSeeder extends Seeder
{
    public function run(): void
    {
        // Solo elimina los BADGE para no tocar recompensas canjeables
        DB::table('rewards')->where('category', 'BADGE')->delete();

        $now = now();

        $badges = [
            [
                'name'            => 'Primer Paso',
                'description'     => 'Completa tu primera acción de reciclaje.',
                'emoji'           => '🌱',
                'points_required' => 1,
                'badge_color'     => '#52b788',
                'order'           => 1,
            ],
            [
                'name'            => 'Reciclador Novato',
                'description'     => 'Acumula 50 puntos reciclando.',
                'emoji'           => '♻️',
                'points_required' => 50,
                'badge_color'     => '#40916c',
                'order'           => 2,
            ],
            [
                'name'            => 'Centurión',
                'description'     => 'Acumula 100 puntos reciclando.',
                'emoji'           => '💯',
                'points_required' => 100,
                'badge_color'     => '#0369a1',
                'order'           => 3,
            ],
            [
                'name'            => 'Guardián Verde',
                'description'     => 'Alcanza el rango Intermedio (200 pts).',
                'emoji'           => '🛡️',
                'points_required' => 200,
                'badge_color'     => '#2d6a4f',
                'order'           => 4,
            ],
            [
                'name'            => 'Medio Camino',
                'description'     => 'Alcanza los 350 puntos totales.',
                'emoji'           => '🌗',
                'points_required' => 350,
                'badge_color'     => '#b45309',
                'order'           => 5,
            ],
            [
                'name'            => 'Eco Warrior',
                'description'     => 'Alcanza el rango Avanzado (600 pts).',
                'emoji'           => '⚔️',
                'points_required' => 600,
                'badge_color'     => '#1b4332',
                'order'           => 6,
            ],
            [
                'name'            => 'Mil Razones',
                'description'     => 'Acumula 1000 puntos reciclando.',
                'emoji'           => '🌍',
                'points_required' => 1000,
                'badge_color'     => '#15803d',
                'order'           => 7,
            ],
            [
                'name'            => 'Leyenda del Reciclaje',
                'description'     => 'Alcanza el rango Experto (1500 pts).',
                'emoji'           => '🏆',
                'points_required' => 1500,
                'badge_color'     => '#7e22ce',
                'order'           => 8,
            ],
        ];

        $rows = array_map(fn($b) => array_merge($b, [
            'id'         => (string) Str::uuid(),
            'category'   => 'BADGE',
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]), $badges);

        DB::table('rewards')->insert($rows);
    }
}