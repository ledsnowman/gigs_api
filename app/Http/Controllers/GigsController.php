<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\GetGigsRequest;
use App\Http\Resources\GigResource;
use App\Models\ORM\Gig;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GigsController extends Controller
{
    CONST PER_PAGE = 10;

    public function index(GetGigsRequest $request): AnonymousResourceCollection
    {
        // 1. Берем СТРОГО валидированные данные
        $validated = $request->validated();

        // Используем eager loading (with), чтобы избежать проблемы N+1
        $query = Gig::with('categories');

        // Фильтрация по нескольким категориям (Many-to-Many)
        if (!empty($validated['categories'])) {
            $query->whereHas('categories', function ($q) use ($validated) {
                $q->whereIn('categories.id', $validated['categories']);
            });
        }

        // Фильтрация по промежутку дат
        if (!empty($validated['date_from'])) {
            $query->where('event_date', '>=', Carbon::parse($validated['date_from'])->startOfDay());
        }

        if (!empty($validated['date_to'])) {
            $query->where('event_date', '<=', Carbon::parse($validated['date_to'])->endOfDay());
        }

        // Получаем per_page из валидированных данных, либо берем дефолт
        $per_page = $validated['per_page'] ?? self::PER_PAGE;

        // Сортируем события: сначала ближайшие
        $query->orderBy('event_date', 'asc');

        // Пагинация
        $gigs = $query->paginate((int)$per_page);

        return GigResource::collection($gigs);
    }
}
