<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateApiUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-api-user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error("User with email '{$email}' already exists!");
            return Command::FAILURE;
        }

        DB::Transaction(function () use ($name, $email, $password) {
            // 1. Создаем пользователя в БД
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $token = $user->createToken('api-custom-token');

            $this->newLine();
            $this->table(
                ['Field', 'Value'],
                [
                    ['User ID', $user->id],
                    ['Name', $name],
                    ['Email', $email],
                ]
            );

            $this->info('--- BEARER TOKEN FOR YOUR REQUESTS ---');
            $this->comment($token->plainTextToken);
            $this->info('--------------------------------------');

            return Command::SUCCESS;
        });
    }
}
