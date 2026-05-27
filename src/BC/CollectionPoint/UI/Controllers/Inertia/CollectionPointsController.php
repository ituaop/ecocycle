<?php
namespace Src\Recycling\CollectionPoint\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class CollectionPointsController extends Controller
{
    public function index(): Response
    {
        $points = DB::table('collection_points')
            ->orderByRaw("CASE status WHEN 'ACTIVE' THEN 0 WHEN 'FULL' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->get()
            ->map(fn($cp) => [
                'id'                  => $cp->id,
                'name'                => $cp->name,
                'address'             => $cp->address,
                'latitude'            => (float) $cp->latitude,
                'longitude'           => (float) $cp->longitude,
                'status'              => $cp->status,
                'schedule'            => $cp->schedule,
                'accepted_categories' => json_decode($cp->accepted_categories, true),
            ])
            ->toArray();

        return Inertia::render('CollectionPoints/Index', [
            'collectionPoints' => $points,
        ]);
    }
}
