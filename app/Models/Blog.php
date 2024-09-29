<?php

namespace App\Models;

use App\Http\Resources\BlogResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'description', 'user_id', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createBlog(Request $request)
    {
        $image = saveFile($request->image, 'images/blogs', $request->image->getClientOriginalName());
        $slug = generateSlug($request->title);

        $blog = $this;
        $blog->user_id = auth()->user()->id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->image = $image['name'];
        $blog->slug = $slug;
        $blog->save();

        $blog = new BlogResource($blog);
        return response()->json(['status' => 200, 'message' => 'Blog created successfully.', 'data' => $blog]);
    }

    public function getAllBlogs(Request $request)
    {
        $blogs = $this;
        $blogs = $blogs->orderByDesc('id')->get();
        $colection = BlogResource::collection($blogs);
        return response()->json(['status' => 200, 'data' => $colection]);
    }

    public function deleteBlog(Request $request, $blog): array|Catalog|Collection|Model|null
    {
        $blog = $this->find($blog);
        if ($blog) {
            $blog->delete();
        }
        return response()->json(['status' => 200, 'message' => 'Blog deleted successfully.', 'data' => $blog]);
    }

    public function getCatalogBySlug(Request $request, $slug)
    {
        $blog = $this->where('slug', $slug)->first();
        $blog = new BlogResource($blog);
        return response()->json(['status' => 200, 'data' => $blog]);
    }

    public function updateBlog(Request $request, $blog)
    {
        $blog = $this->find($blog);
        if ($request->image) {
            $image = saveFile($request->image, 'images/blogs', $request->image->getClientOriginalName());
            $blog->image = $image['name'];
        }
        $blog->category_id = $request->category_id;
        $blog->user_id = auth()->user()->id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->image = $image['name'];
        if ($blog->title !== $request->title) {
            $slug = generateSlug($request->title);
            $blog->slug = $slug;
        }
        $blog->update();

        $blog = new BlogResource($blog);
        return response()->json(['status' => 200, 'message' => 'Blog updated successfully.', 'data' => $blog]);
    }
}
