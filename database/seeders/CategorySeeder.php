<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ORM\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Список ваших категорий
        $categories = [
            'Выставки',
            'Детям',
            'Квесты',
            'Концерты и шоу',
            'Лекции',
            'Кинопоказы',
            'Спорт',
            'Мастер-классы',
            'Спектакли',
            'Прогулки',
            'Экскурсии',
        ];

        foreach ($categories as $name) {
            // updateOrCreate предотвратит дублирование при повторном запуске
            Category::updateOrCreate(
                ['slug' => Str::slug($name)], // Уникальный идентификатор (например, "koncerty-i-sou")
                ['name' => $name]
            );
        }
    }
}
