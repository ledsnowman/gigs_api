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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Уникальное название категории
            $table->string('slug')->unique(); // URL-friendly идентификатор
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gig_category', function (Blueprint $table) {
            $table->id();

            // Внешний ключ на афишу. При удалении афиши связь удалится автоматически
            $table->foreignId('gig_id')
                ->constrained()
                ->cascadeOnDelete();

            // Внешний ключ на категорию. При удалении категории связь удалится автоматически
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            // Защита от дублирования одинаковых связей
            $table->unique(['gig_id', 'category_id']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
