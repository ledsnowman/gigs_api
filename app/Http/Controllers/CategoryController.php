<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ORM\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Получаем все категории, отсортированные по имени
        $categories = Category::orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200);
    }
}
