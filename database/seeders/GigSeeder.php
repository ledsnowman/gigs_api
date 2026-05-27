<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ORM\Category;
use App\Models\ORM\Gig;
use Illuminate\Database\Seeder;

class GigSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Получаем все существующие категории из базы
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Категории не найдены. Сначала запустите CategorySeeder!');
            return;
        }

        // 2. Генерируем 10 ПРОШЕДШИХ событий
        $pastGigs = Gig::factory()
            ->count(10)
            ->past() // Используем состояние из фабрики
            ->create();

        // 3. Генерируем 30 БУДУЩИХ событий
        $futureGigs = Gig::factory()
            ->count(30)
            ->create();

        // Объединяем коллекции для привязки категорий
        $allGigs = $pastGigs->concat($futureGigs);

        // 4. Привязываем категории, выполняя условия ТЗ
        foreach ($allGigs as $index => $gig) {
            // Чтобы ГАРАНТИРОВАННО задействовать ВСЕ категории:
            // Первые 11 событий получат строго по одной уникальной категории из списка
            if ($index < $categories->count()) {
                $gig->categories()->attach($categories[$index]->id);
                continue;
            }

            // Для всех остальных событий выбираем случайное количество случайных категорий (от 1 до 3)
            $randomCategories = $categories->random(rand(1, 3))->pluck('id')->toArray();
            $gig->categories()->attach($randomCategories);
        }
    }
}
