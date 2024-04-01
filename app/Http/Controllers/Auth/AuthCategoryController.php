<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthCategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = new Category([
            'name' => $request->name,
            'description' => $request->description,

        ]);
        $category->save();

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'category created successfully'
        ], 201);
    }
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json($category, 200);
        } else {
            return response()->json([
                'message' => 'category not found', 404
            ]);
        }
    }
    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($category) {
            $category->update($validateData);
            return response()->json($category, 200);
        } else {
            return response()->json(['message' => 'Product not found', 404]);
        }
    }
    public function delete(Category $category)
    {
        if ($category) {
            $category->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'category not found'], 404);
        }
    }
}
