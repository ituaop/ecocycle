<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        $rewards = [
            // Primeros pasos (0–50 pts)
            [
                'name'             => 'Primer paso',
                'description'      => 'Has reciclado por primera vez. ¡Bienvenido al cambio!',
                'emoji'            => '🌱',
                'category'         => 'BADGE',
                'points_required'  => 10,
                'badge_color'      => '#15803d',
                'order'            => 1,
            ],
            [
                'name'             => 'Explorador verde',
                'description'      => 'Has probado al menos 3 categorías de reciclaje distintas.',
                'emoji'            => '🧭',
                'category'         => 'BADGE',
                'points_required'  => 30,
                'badge_color'      => '#0d9488',
                'order'            => 2,
            ],
            [
                'name'             => 'Descuento 5% tienda eco',
                'description'      => 'Canjea este cupón en cualquier tienda ecológica colaboradora. Código: ECO-5OFF',
                'emoji'            => '🏷️',
                'category'         => 'DISCOUNT',
                'points_required'  => 50,
                'badge_color'      => '#a16207',
                'order'            => 3,
            ],

            // Nivel Intermedio (100–300 pts)
            [
                'name'             => 'Guerrero del reciclaje',
                'description'      => 'Llevas más de 100 puntos acumulados. ¡Eres un ejemplo!',
                'emoji'            => '⚡',
                'category'         => 'BADGE',
                'points_required'  => 100,
                'badge_color'      => '#1d4ed8',
                'order'            => 4,
            ],
            [
                'name'             => 'Árbol plantado a tu nombre',
                'description'      => 'Con tus puntos financiamos la plantación de un árbol real en zonas deforestadas.',
                'emoji'            => '🌳',
                'category'         => 'DONATION',
                'points_required'  => 150,
                'badge_color'      => '#15803d',
                'order'            => 5,
            ],
            [
                'name'             => 'Entrada cine ecológico',
                'description'      => 'Acceso gratuito a la próxima sesión de cine medioambiental de tu ciudad.',
                'emoji'            => '🎬',
                'category'         => 'EXPERIENCE',
                'points_required'  => 200,
                'badge_color'      => '#7e22ce',
                'order'            => 6,
            ],
            [
                'name'             => 'Descuento 15% productos sostenibles',
                'description'      => 'Descuento exclusivo en nuestra tienda online de productos eco. Código: ECO-15OFF',
                'emoji'            => '🛍️',
                'category'         => 'DISCOUNT',
                'points_required'  => 250,
                'badge_color'      => '#a16207',
                'order'            => 7,
            ],
            [
                'name'             => 'Maestro del reciclaje',
                'description'      => 'Has alcanzado los 300 puntos. Tu compromiso con el planeta es admirable.',
                'emoji'            => '🥇',
                'category'         => 'BADGE',
                'points_required'  => 300,
                'badge_color'      => '#92400e',
                'order'            => 8,
            ],

            // Nivel Avanzado (400–800 pts)
            [
                'name'             => 'Visita a planta de reciclaje',
                'description'      => 'Tour guiado exclusivo por una planta de reciclaje local. Cupo limitado.',
                'emoji'            => '🏭',
                'category'         => 'EXPERIENCE',
                'points_required'  => 400,
                'badge_color'      => '#0d9488',
                'order'            => 9,
            ],
            [
                'name'             => '10 kg de plástico retirado del océano',
                'description'      => 'Donamos en tu nombre para retirar 10 kg de plástico del océano con ONG colaboradora.',
                'emoji'            => '🌊',
                'category'         => 'DONATION',
                'points_required'  => 500,
                'badge_color'      => '#1d4ed8',
                'order'            => 10,
            ],
            [
                'name'             => 'Pack kit reciclaje en casa',
                'description'      => 'Recibe en tu domicilio un kit completo con contenedores de colores y guía de reciclaje.',
                'emoji'            => '📦',
                'category'         => 'EXPERIENCE',
                'points_required'  => 600,
                'badge_color'      => '#92400e',
                'order'            => 11,
            ],
            [
                'name'             => 'Descuento 25% bicicleta eléctrica',
                'description'      => 'Descuento especial en la compra de una bicicleta eléctrica de nuestros partners. Código: ECO-BIKE25',
                'emoji'            => '🚲',
                'category'         => 'DISCOUNT',
                'points_required'  => 700,
                'badge_color'      => '#a16207',
                'order'            => 12,
            ],
            [
                'name'             => 'Héroe del planeta',
                'description'      => 'Eres uno de los recicladores más activos de nuestra comunidad. ¡Gracias!',
                'emoji'            => '🦸',
                'category'         => 'BADGE',
                'points_required'  => 800,
                'badge_color'      => '#7e22ce',
                'order'            => 13,
            ],

            // Nivel Experto (1000–1500 pts)
            [
                'name'             => 'Fin de semana en alojamiento sostenible',
                'description'      => '2 noches en un alojamiento rural sostenible certificado. Para 2 personas.',
                'emoji'            => '🏡',
                'category'         => 'EXPERIENCE',
                'points_required'  => 1000,
                'badge_color'      => '#15803d',
                'order'            => 14,
            ],
            [
                'name'             => 'Panel solar comunitario',
                'description'      => 'Financiamos en tu nombre la instalación de un panel solar en una comunidad sin recursos.',
                'emoji'            => '☀️',
                'category'         => 'DONATION',
                'points_required'  => 1200,
                'badge_color'      => '#a16207',
                'order'            => 15,
            ],
            [
                'name'             => 'Leyenda EcoCycle',
                'description'      => 'El rango más alto posible. Tu huella ecológica positiva es extraordinaria. ¡Leyenda!',
                'emoji'            => '🏆',
                'category'         => 'BADGE',
                'points_required'  => 1500,
                'badge_color'      => '#7e22ce',
                'order'            => 16,
            ],
        ];

        foreach ($rewards as $reward) {
            DB::table('rewards')->updateOrInsert(
                ['name' => $reward['name']],
                array_merge($reward, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}