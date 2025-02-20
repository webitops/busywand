<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->load('products.variants');

        return Inertia::render('Categories/Index', [
            'categories' => CategoryResource::collection($categories)->only(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        return to_route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return to_route('categories.index');
    }
}
