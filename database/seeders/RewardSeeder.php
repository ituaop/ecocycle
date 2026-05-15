<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rewards')->truncate();

        $now = now();

        $badges = [
            [
                'name'            => 'Primer Paso',
                'description'     => 'Completa tu primera acción de reciclaje.',
                'emoji'           => '🌱',
                'category'        => 'BADGE',
                'points_required' => 1,
                'badge_color'     => '#52b788',
                'order'           => 1,
            ],
            [
                'name'            => 'Reciclador Novato',
                'description'     => 'Acumula 50 puntos reciclando.',
                'emoji'           => '♻️',
                'category'        => 'BADGE',
                'points_required' => 50,
                'badge_color'     => '#40916c',
                'order'           => 2,
            ],
            [
                'name'            => 'Guardián Verde',
                'description'     => 'Alcanza el rango Intermedio (200 pts).',
                'emoji'           => '🛡️',
                'category'        => 'BADGE',
                'points_required' => 200,
                'badge_color'     => '#2d6a4f',
                'order'           => 3,
            ],
            [
                'name'            => 'Eco Warrior',
                'description'     => 'Alcanza el rango Avanzado (600 pts).',
                'emoji'           => '⚔️',
                'category'        => 'BADGE',
                'points_required' => 600,
                'badge_color'     => '#1b4332',
                'order'           => 4,
            ],
            [
                'name'            => 'Leyenda del Reciclaje',
                'description'     => 'Alcanza el rango Experto (1500 pts).',
                'emoji'           => '🏆',
                'category'        => 'BADGE',
                'points_required' => 1500,
                'badge_color'     => '#7e22ce',
                'order'           => 5,
            ],
            [
                'name'            => 'Centurión',
                'description'     => 'Acumula 100 puntos reciclando.',
                'emoji'           => '💯',
                'category'        => 'BADGE',
                'points_required' => 100,
                'badge_color'     => '#0369a1',
                'order'           => 6,
            ],
            [
                'name'            => 'Medio Camino',
                'description'     => 'Alcanza los 750 puntos totales.',
                'emoji'           => '🌗',
                'category'        => 'BADGE',
                'points_required' => 750,
                'badge_color'     => '#b45309',
                'order'           => 7,
            ],
            [
                'name'            => 'Mil Razones',
                'description'     => 'Acumula 1000 puntos reciclando.',
                'emoji'           => '🌍',
                'category'        => 'BADGE',
                'points_required' => 1000,
                'badge_color'     => '#15803d',
                'order'           => 8,
            ],
        ];
$discounts = [
            [
                'name'            => 'Tarjeta Regalo Amazon 10€',
                'description'     => 'Código canjeable por valor de 10€ para cualquier compra en Amazon.',
                'emoji'           => '📦',
                'category'        => 'DISCOUNT',
                'points_required' => 600,
                'badge_color'     => '#ff9900',
                'order'           => 1,
            ],
            [
                'name'            => '1 Mes Gratis de Netflix',
                'description'     => 'Tarjeta regalo digital equivalente a una suscripción mensual del Plan Estándar.',
                'emoji'           => '🎬',
                'category'        => 'DISCOUNT',
                'points_required' => 850,
                'badge_color'     => '#e50914',
                'order'           => 2,
            ],
            [
                'name'            => 'Tarjeta Regalo Spotify 10€',
                'description'     => 'Disfruta de tu música favorita sin anuncios. Saldo canjeable en Spotify Premium.',
                'emoji'           => '🎵',
                'category'        => 'DISCOUNT',
                'points_required' => 600,
                'badge_color'     => '#1ed760',
                'order'           => 3,
            ],
            [
                'name'            => 'Descuento Renfe 15€',
                'description'     => 'Código promocional aplicable a cualquier trayecto nacional de AVE o Larga Distancia.',
                'emoji'           => '🚄',
                'category'        => 'DISCOUNT',
                'points_required' => 900,
                'badge_color'     => '#a16207',
                'order'           => 4,
            ],
            [
                'name'            => 'Tarjeta Regalo Decathlon 20€',
                'description'     => 'Cheque para gastar en ropa o equipamiento deportivo en cualquier tienda física u online.',
                'emoji'           => '👟',
                'category'        => 'DISCOUNT',
                'points_required' => 1200,
                'badge_color'     => '#0082c3',
                'order'           => 5,
            ],
        ];

        $experiences = [
            [
                'name'            => 'Escapada de Fin de Semana (Smartbox)',
                'description'     => 'Caja regalo que incluye 1 noche con desayuno para 2 personas en hoteles rurales o costeros.',
                'emoji'           => '🧳',
                'category'        => 'EXPERIENCE',
                'points_required' => 3500,
                'badge_color'     => '#0e7490',
                'order'           => 1,
            ],
            [
                'name'            => 'Cena Gourmet para Dos',
                'description'     => 'Cheque canjeable para una cena gastronómica de menú cerrado en restaurantes seleccionados.',
                'emoji'           => '🍽️',
                'category'        => 'EXPERIENCE',
                'points_required' => 2200,
                'badge_color'     => '#b45309',
                'order'           => 2,
            ],
            [
                'name'            => 'Circuito de Spa y Masaje',
                'description'     => 'Entrada individual para un circuito relajante de aguas termales con masaje de 30 min incluido.',
                'emoji'           => '💆',
                'category'        => 'EXPERIENCE',
                'points_required' => 1500,
                'badge_color'     => '#ec4899',
                'order'           => 3,
            ],
        ];

        $donations = [
            [
                'name'            => 'Botella Térmica de Acero Inoxidable',
                'description'     => 'Botella reutilizable de alta resistencia (750ml). Mantiene el frío 24h y el calor 12h.',
                'emoji'           => '🍼',
                'category'        => 'DONATION',
                'points_required' => 450,
                'badge_color'     => '#06b6d4',
                'order'           => 1,
            ],
            [
                'name'            => 'Auriculares Inalámbricos Eco-friendly',
                'description'     => 'Auriculares Bluetooth fabricados con plásticos reciclados del océano y madera certificada.',
                'emoji'           => '🎧',
                'category'        => 'DONATION',
                'points_required' => 1800,
                'badge_color'     => '#111827',
                'order'           => 2,
            ],
            [
                'name'            => 'Patinete Eléctrico Xiaomi',
                'description'     => 'El premio gordo. Patinete de movilidad sostenible de última generación con 30km de autonomía.',
                'emoji'           => '🛴',
                'category'        => 'DONATION',
                'points_required' => 9500,
                'badge_color'     => '#16a34a',
                'order'           => 3,
            ],
        ];

        $all = array_merge($badges, $discounts, $experiences, $donations);

        $rows = array_map(fn($r) => array_merge($r, [
            'id'         => (string) Str::uuid(),
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]), $all);

        DB::table('rewards')->insert($rows);
    }
}