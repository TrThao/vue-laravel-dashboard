<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthBlogController extends Controller
{
    public function index()
    {
        $blog = Blog::all();
        return response()->json($blog, 200);
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $blog = new Blog([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);
        $blog->save();

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog created successfully'
        ], 201);
    }


    public function show(string $id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            return response()->json($blog, 200);
        } else {
            return response()->json([
                'message' => 'blog not found', 404
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        // Kiểm tra xem blog có tồn tại không
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;

            // Kiểm tra xem blog có chứa ảnh cũ không
            if ($blog->image) {
                // Xóa ảnh cũ
                unlink(public_path($blog->image));
            }

            // Cập nhật đường dẫn ảnh mới
            $blog->image = $imagePath;
        }

        // Cập nhật thông tin title và content của blog
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->category_id = $request->category_id;
        $blog->save();

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog updated successfully'
        ], 200);
    }
    public function delete(Blog $blog)
    {
        if ($blog) {

            if ($blog->image) {
                $imagePath = public_path($blog->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $blog->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Blog not found'], 404);
        }
    }
}