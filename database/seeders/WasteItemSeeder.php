<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WasteItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // PLASTIC
            ['name' => 'Botella PET',          'description' => 'Botellas de agua, refrescos y bebidas en plástico PET. Deben estar limpias y sin tapón.',  'category' => 'PLASTIC',    'points' => 5],
            ['name' => 'Envase de yogur',       'description' => 'Envases de plástico de yogur, natillas o postres lácteos. Enjuagar antes de depositar.',    'category' => 'PLASTIC',    'points' => 3],
            ['name' => 'Bolsa de plástico',     'description' => 'Bolsas de supermercado, de basura o de cualquier tipo de plástico fino.',                    'category' => 'PLASTIC',    'points' => 2],
            ['name' => 'Envase de champú',      'description' => 'Botellas de plástico de champú, gel de ducha, jabón líquido o productos de higiene.',        'category' => 'PLASTIC',    'points' => 4],
            ['name' => 'Bandeja de poliespán',  'description' => 'Bandejas de poliestireno usadas en envases de carne, pescado o verduras del supermercado.',   'category' => 'PLASTIC',    'points' => 3],
            ['name' => 'Tapón de plástico',     'description' => 'Tapones de botellas, bricks y envases de plástico. Pueden depositarse sueltos.',              'category' => 'PLASTIC',    'points' => 1],
            // GLASS
            ['name' => 'Botella de vidrio',     'description' => 'Botellas de vino, cerveza, aceite u otras bebidas en vidrio. Sin tapa metálica.',             'category' => 'GLASS',      'points' => 8],
            ['name' => 'Tarro de conserva',     'description' => 'Tarros de cristal de mermeladas, conservas, salsas u otros alimentos.',                       'category' => 'GLASS',      'points' => 6],
            ['name' => 'Frasco de perfume',     'description' => 'Frascos de vidrio de perfumes, colonias o cosméticos. Deben estar vacíos.',                   'category' => 'GLASS',      'points' => 5],
            ['name' => 'Vasija de cristal',     'description' => 'Vasijas, copas o recipientes de cristal roto o en desuso.',                                   'category' => 'GLASS',      'points' => 4],
            // PAPER
            ['name' => 'Periódico',             'description' => 'Periódicos, revistas y publicaciones impresas. Deben estar secos y sin plástico.',             'category' => 'PAPER',      'points' => 3],
            ['name' => 'Cartón de caja',        'description' => 'Cajas de cartón de cualquier tamaño, aplastadas para ahorrar espacio en el contenedor.',       'category' => 'PAPER',      'points' => 4],
            ['name' => 'Brick de leche',        'description' => 'Envases brick de leche, zumo o bebidas vegetales. Enjuagar y aplastar.',                       'category' => 'PAPER',      'points' => 4],
            ['name' => 'Papel de oficina',      'description' => 'Folios, cuadernos, sobres y papel impreso de oficina o uso doméstico.',                        'category' => 'PAPER',      'points' => 2],
            ['name' => 'Cartón de huevos',      'description' => 'Cajas de cartón de huevos vacías y limpias.',                                                 'category' => 'PAPER',      'points' => 2],
            // METAL
            ['name' => 'Lata de aluminio',      'description' => 'Latas de refrescos, cerveza o bebidas energéticas de aluminio. Aplasta para ahorrar espacio.', 'category' => 'METAL',      'points' => 6],
            ['name' => 'Lata de conserva',      'description' => 'Latas de atún, tomate, legumbres u otros alimentos en conserva metálica.',                     'category' => 'METAL',      'points' => 5],
            ['name' => 'Aerosol vacío',         'description' => 'Sprays y aerosoles completamente vacíos de desodorante, laca, pintura o similar.',             'category' => 'METAL',      'points' => 4],
            ['name' => 'Papel de aluminio',     'description' => 'Papel de aluminio de cocina limpio y otros envases de aluminio fino.',                         'category' => 'METAL',      'points' => 3],
            // ORGANIC
            ['name' => 'Restos de comida',      'description' => 'Restos de frutas, verduras, cáscaras y otros alimentos cocinados o crudos.',                  'category' => 'ORGANIC',    'points' => 4],
            ['name' => 'Posos de café',         'description' => 'Posos de café, filtros de papel usados e infusiones.',                                         'category' => 'ORGANIC',    'points' => 3],
            ['name' => 'Restos de jardín',      'description' => 'Hojas secas, ramas pequeñas, hierba cortada y restos de poda de jardín.',                     'category' => 'ORGANIC',    'points' => 5],
            // ELECTRONIC
            ['name' => 'Móvil viejo',           'description' => 'Teléfonos móviles en desuso, aunque estén rotos. Contienen materiales recuperables.',         'category' => 'ELECTRONIC', 'points' => 20],
            ['name' => 'Ordenador portátil',    'description' => 'Portátiles, tablets y ordenadores que ya no funcionan o están en desuso.',                    'category' => 'ELECTRONIC', 'points' => 35],
            ['name' => 'Pila o batería',        'description' => 'Pilas alcalinas, de botón, baterías de litio y acumuladores de cualquier tipo.',              'category' => 'ELECTRONIC', 'points' => 10],
            ['name' => 'Bombilla LED',          'description' => 'Bombillas LED, fluorescentes compactas y tubos de luz en desuso.',                             'category' => 'ELECTRONIC', 'points' => 8],
            ['name' => 'Cable eléctrico',       'description' => 'Cables USB, cargadores, extensiones y cualquier tipo de cable eléctrico.',                    'category' => 'ELECTRONIC', 'points' => 7],
            ['name' => 'Electrodoméstico pequeño', 'description' => 'Tostadoras, secadores, cafeteras u otros pequeños electrodomésticos en desuso.',           'category' => 'ELECTRONIC', 'points' => 25],
        ];

        foreach ($items as $item) {
            DB::table('waste_items')->updateOrInsert(['name' => $item['name']], array_merge($item, [
                'id'         => Str::uuid()->toString(),
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
