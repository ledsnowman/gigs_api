<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetUserPassword extends Command
{
    // Название и аргументы команды (email обязательный, password — опциональный)
    protected $signature = 'user:reset-password {email} {password?}';

    // Описание команды для списка php artisan
    protected $description = 'Сбрасывает пароль пользователя по email и генерирует новый API-токен Sanctum';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // 1. Поиск пользователя
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Пользователь с email {$email} не найден.");
            return Command::FAILURE;
        }

        // 2. Генерация или использование переданного пароля
        if (!$password) {
            $password = Str::random(12); // Случайный пароль из 12 символов
        }

        // 3. Обновление пароля в базе данных
        $user->password = Hash::make($password);
        $user->save();

        // 4. Отзыв старых токенов (опционально, для безопасности)
        $user->tokens()->delete();

        // 5. Создание нового токена Sanctum
        $token = $user->createToken('console_auth_token')->plainTextToken;

        // 6. Вывод результата в консоль
        $this->info("Пароль для пользователя {$email} успешно изменен!");
        $this->line("Новый пароль: <comment>{$password}</comment>");
        $this->line("Новый Sanctum токен: <comment>{$token}</comment>");

        return Command::SUCCESS;
    }
}
