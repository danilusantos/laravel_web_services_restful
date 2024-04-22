<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function index(Request $request)
    {
        $categories = $this->category->getResults($request->name);

        return response()->json($categories, 200);
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->category->create($request->all());

        return response()->json($category, 201);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $category->update($request->all());

        return response()->json($category, 200);
    }
}
