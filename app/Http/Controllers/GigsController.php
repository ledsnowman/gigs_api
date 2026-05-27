<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetGigsRequest;
use App\Http\Resources\GigResource;
use App\Models\ORM\Gig;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GigsController extends Controller
{
    CONST PER_PAGE = 10;

    public function index(GetGigsRequest $request): AnonymousResourceCollection
    {
        // Используем eager loading (with), чтобы избежать проблемы N+1 запросов к категориям
        $query = Gig::with('categories');

        // Фильтрация по нескольким категориям (Many-to-Many)
        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->input('categories'));
            });
        }

        // Фильтрация по промежутку дат
        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->input('date_to'));
        }

        $per_page = $request->filled('per_page') ? $request->input('per_page') : self::PER_PAGE;

        // Сортируем события: сначала ближайшие
        $query->orderBy('event_date', 'asc');

        // Пагинация по 10 элементов на страницу
        $gigs = $query->paginate($per_page);

        return GigResource::collection($gigs);
    }
}
