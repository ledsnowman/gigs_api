<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Создаем фиксированного пользователя для тестирования API
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test API User',
                'password' => Hash::make('password'), // Пароль для входа, если понадобится
            ]
        );

        // 2. Генерируем для него постоянный токен
        // Сначала удаляем старые токены этого пользователя, чтобы не плодить дубликаты при повторном сидинге
        $user->tokens()->delete();

        // Создаем новый токен
        $token = $user->createToken('postman-api-token');

        // 3. Выводим токен прямо в консоль при запуске сидера, чтобы его можно было скопировать
        $this->command->newLine();
        $this->command->info('==================================================');
        $this->command->info('  TEST USER BEARER TOKEN FOR POSTMAN / CURL:      ');
        $this->command->comment('  ' . $token->plainTextToken);
        $this->command->info('==================================================');
        $this->command->newLine();

        $this->call([
            CategorySeeder::class,
            GigSeeder::class,
        ]);
    }
}
