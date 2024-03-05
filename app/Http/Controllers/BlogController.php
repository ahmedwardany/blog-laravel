<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return BlogResource::collection($blogs);
    }

    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }

        return new BlogResource($blog);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'publish_date' => 'required|date',
        ]);

        $blog = new Blog;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->publish_date = $request->publish_date;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images');
            $blog->image = $imagePath;
        }

        $blog->save();

        return new BlogResource($blog);
    }

    public function update(Request $request, $id)
    {
        Log::error($request->title);
        $blog = Blog::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'publish_date' => 'required|date',
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->publish_date = $request->publish_date;

        // Handle image update
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images');
            $blog->image = $imagePath;
        }

        $blog->save();

        return new BlogResource($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(null, 204);
    }
}
