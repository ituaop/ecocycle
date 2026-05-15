<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        DB::table('challenges')->truncate();

        Schema::enableForeignKeyConstraints();
        $now   = Carbon::now();
        $week  = [$now->startOfWeek()->toDateString(), $now->copy()->endOfWeek()->toDateString()];
        $month = [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()];

        $challenges = [
            [
                'title'        => 'Recicla 5 veces esta semana',
                'description'  => 'Completa 5 acciones de reciclaje antes del domingo.',
                'emoji'        => '🔥',
                'type'         => 'WEEKLY',
                'category'     => 'QUANTITY',
                'target_value' => 5,
                'bonus_points' => 50,
                'badge_color'  => '#f97316',
                'starts_at'    => $week[0],
                'ends_at'      => $week[1],
            ],
            [
                'title'        => 'Variedad verde',
                'description'  => 'Recicla 3 tipos de materiales distintos esta semana.',
                'emoji'        => '🌈',
                'type'         => 'WEEKLY',
                'category'     => 'VARIETY',
                'target_value' => 3,
                'bonus_points' => 40,
                'badge_color'  => '#8b5cf6',
                'starts_at'    => $week[0],
                'ends_at'      => $week[1],
            ],
            [
                'title'        => 'Acumula 100 pts esta semana',
                'description'  => 'Gana 100 puntos reciclando antes del domingo.',
                'emoji'        => '⚡',
                'type'         => 'WEEKLY',
                'category'     => 'POINTS',
                'target_value' => 100,
                'bonus_points' => 30,
                'badge_color'  => '#eab308',
                'starts_at'    => $week[0],
                'ends_at'      => $week[1],
            ],
            [
                'title'        => 'Reciclador del mes',
                'description'  => 'Completa 20 acciones de reciclaje este mes.',
                'emoji'        => '🏆',
                'type'         => 'MONTHLY',
                'category'     => 'QUANTITY',
                'target_value' => 20,
                'bonus_points' => 200,
                'badge_color'  => '#2d6a4f',
                'starts_at'    => $month[0],
                'ends_at'      => $month[1],
            ],
            [
                'title'        => 'Maestro de materiales',
                'description'  => 'Recicla al menos 8 tipos de materiales distintos este mes.',
                'emoji'        => '🧪',
                'type'         => 'MONTHLY',
                'category'     => 'VARIETY',
                'target_value' => 8,
                'bonus_points' => 150,
                'badge_color'  => '#0369a1',
                'starts_at'    => $month[0],
                'ends_at'      => $month[1],
            ],
            [
                'title'        => 'Acumula 500 pts este mes',
                'description'  => 'Llega a los 500 puntos de reciclaje en el mes.',
                'emoji'        => '💎',
                'type'         => 'MONTHLY',
                'category'     => 'POINTS',
                'target_value' => 500,
                'bonus_points' => 100,
                'badge_color'  => '#7c3aed',
                'starts_at'    => $month[0],
                'ends_at'      => $month[1],
            ],
            [
                'title'        => 'Día de la Tierra x2',
                'description'  => 'Recicla 10 veces durante la semana del Día de la Tierra.',
                'emoji'        => '🌍',
                'type'         => 'SPECIAL',
                'category'     => 'QUANTITY',
                'target_value' => 10,
                'bonus_points' => 300,
                'badge_color'  => '#15803d',
                'starts_at'    => '2025-04-18',
                'ends_at'      => '2025-04-25',
            ],
        ];

        $rows = array_map(fn($c) => array_merge($c, [
            'id'         => (string) Str::uuid(),
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]), $challenges);

        DB::table('challenges')->insert($rows);
    }
}