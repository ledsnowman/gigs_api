<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gigs', function (Blueprint $blueprint) {
            $blueprint->id(); // Автоинкрементный ID (BIGINT)
            $blueprint->string('title'); // Название афиши (VARCHAR 255)
            $blueprint->text('description'); // Текст афиши
            $blueprint->dateTime('event_date'); // Дата и время мероприятия
            $blueprint->boolean('archived')->default(false);
            $blueprint->timestamps(); // Создает поля created_at и updated_at
            $blueprint->softDeletes(); // Создает поле deleted_at для мягкого удаления
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
