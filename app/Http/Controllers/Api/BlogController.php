<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCreateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blog;
    function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function createBlog(BlogCreateRequest $request)
    {
        try {
            return $this->blog->createBlog($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updateBlog(Request $request, $blog)
    {
        try {
            return $this->blog->updateBlog($request, $blog);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function deleteBlog(Request $request, $blog)
    {
        try {
            return $this->blog->deleteBlog($request, $blog);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getAllBlogs(Request $request)
    {
        try {
            return $this->blog->getAllBlogs($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getBlogBySlug(Request $request, $slug)
    {
        try {
            return $this->blog->getBlogBySlug($request, $slug);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }
}
