<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ORM\Gig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gig>
 */
class GigFactory extends Factory
{
    protected $model = Gig::class;

    /**
     * Базовое состояние: генерирует случайное будущее событие
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                    'Большой рок-концерт', 'Выставка цифрового искусства', 'Квест в темноте',
                    'Лекция о космосе', 'Мастер-класс по живописи', 'Ночной кинопоказ',
                    'Футбольный матч', 'Театральный спектакль', 'Прогулка по крышам',
                    'Экскурсия в подземку', 'Детский интерактивный праздник'
                ]) . ' ' . $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph(3),
            'event_date' => $this->faker->dateTimeBetween('+1 days', '+3 months'), // Будущее время
        ];
    }

    /**
     * Состояние для генерации прошедших событий (архивных)
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => $this->faker->dateTimeBetween('-6 months', '-1 days'), // Прошедшее время
        ]);
    }
}
