<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollectionPointSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            [
                'name'                => 'Punto Verde Central',
                'address'             => 'Plaza del Ayuntamiento, 1, Valencia',
                'latitude'            => 39.4699,
                'longitude'           => -0.3763,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 08:00-22:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL']),
            ],
            [
                'name'                => 'Ecoparque Norte',
                'address'             => 'Av. de Burjassot, 47, Valencia',
                'latitude'            => 39.4892,
                'longitude'           => -0.3891,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-V 09:00-18:00, S 09:00-14:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL','ELECTRONIC','ORGANIC']),
            ],
            [
                'name'                => 'Punto Limpio Ruzafa',
                'address'             => 'Calle de Cuba, 8, Valencia',
                'latitude'            => 39.4602,
                'longitude'           => -0.3714,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 07:00-23:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL']),
            ],
            [
                'name'                => 'Contenedor Campanar',
                'address'             => 'Av. de Campanar, 90, Valencia',
                'latitude'            => 39.4821,
                'longitude'           => -0.4012,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 07:00-23:00',
                'accepted_categories' => json_encode(['PLASTIC','PAPER','METAL']),
            ],
            [
                'name'                => 'Ecoparque Sur',
                'address'             => 'Calle de Benicarló, 14, Valencia',
                'latitude'            => 39.4451,
                'longitude'           => -0.3689,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-V 08:00-19:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL','ELECTRONIC','ORGANIC']),
            ],
            [
                'name'                => 'Punto Verde Benimaclet',
                'address'             => 'Plaza de Benimaclet, 3, Valencia',
                'latitude'            => 39.4831,
                'longitude'           => -0.3598,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 08:00-22:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL']),
            ],
            [
                'name'                => 'Punto Electrónico Patraix',
                'address'             => 'Calle de Músico Ayllon, 5, Valencia',
                'latitude'            => 39.4563,
                'longitude'           => -0.3941,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-S 09:00-20:00',
                'accepted_categories' => json_encode(['ELECTRONIC']),
            ],
            [
                'name'                => 'Contenedor Orgánico Mestalla',
                'address'             => 'Av. de Suecia, 22, Valencia',
                'latitude'            => 39.4746,
                'longitude'           => -0.3587,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 07:00-22:00',
                'accepted_categories' => json_encode(['ORGANIC','PAPER']),
            ],
            [
                'name'                => 'Punto Verde Quatre Carreres',
                'address'             => 'Calle de la Reina, 45, Valencia',
                'latitude'            => 39.4520,
                'longitude'           => -0.3620,
                'status'              => 'FULL',
                'schedule'            => 'L-D 07:00-23:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL']),
            ],
            [
                'name'                => 'Ecoparque Poblats Marítims',
                'address'             => 'Calle del Doctor Lluch, 60, Valencia',
                'latitude'            => 39.4631,
                'longitude'           => -0.3312,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-V 08:00-20:00, S 08:00-14:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL','ELECTRONIC','ORGANIC']),
            ],
            [
                'name'                => 'Contenedor Residuos Algirós',
                'address'             => 'Av. del Primat Reig, 101, Valencia',
                'latitude'            => 39.4762,
                'longitude'           => -0.3530,
                'status'              => 'INACTIVE',
                'schedule'            => null,
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER']),
            ],
            [
                'name'                => 'Punto Limpio Jesús',
                'address'             => 'Calle de San Vicente Mártir, 200, Valencia',
                'latitude'            => 39.4551,
                'longitude'           => -0.3810,
                'status'              => 'ACTIVE',
                'schedule'            => 'L-D 08:00-21:00',
                'accepted_categories' => json_encode(['PLASTIC','GLASS','PAPER','METAL','ORGANIC']),
            ],
        ];

        foreach ($points as $point) {
            DB::table('collection_points')->updateOrInsert(
                ['name' => $point['name']],
                array_merge($point, [
                    'id'         => Str::uuid()->toString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
