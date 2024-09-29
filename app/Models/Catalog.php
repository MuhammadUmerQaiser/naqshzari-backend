<?php

namespace App\Models;

use App\Http\Resources\CatalogResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'description', 'user_id', 'color', 'fabric', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createCatalog(Request $request)
    {
        $image = saveFile($request->image, 'images/catalogs', $request->image->getClientOriginalName());
        $slug = generateSlug($request->title);

        $product = $this;
        $product->user_id = auth()->user()->id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $image['name'];
        $product->color = $request->color;
        $product->fabric = $request->fabric;
        $product->slug = $slug;
        $product->save();

        $product = new CatalogResource($product);
        return response()->json(['status' => 200, 'message' => 'Catalog created successfully.', 'data' => $product]);
    }

    public function getAllCatalogs(Request $request)
    {
        $products = $this;
        $products = $products->orderByDesc('id')->get();
        $colection = CatalogResource::collection($products);
        return response()->json(['status' => 200, 'data' => $colection]);
    }

    public function deleteCatalog(Request $request, $catalog): array|Catalog|Collection|Model|null
    {
        $product = $this->find($catalog);
        if ($product) {
            $product->delete();
        }
        return response()->json(['status' => 200, 'message' => 'Catalog deleted successfully.', 'data' => $product]);
    }

    public function getCatalogBySlug(Request $request, $slug)
    {
        $product = $this->where('slug', $slug)->first();
        $product = new CatalogResource($product);
        return response()->json(['status' => 200, 'data' => $product]);
    }

    public function updateCatalog(Request $request, $catalog)
    {
        $product = $this->find($catalog);
        if ($request->image) {
            $image = saveFile($request->image, 'images/catalogs', $request->image->getClientOriginalName());
            $product->image = $image['name'];
        }
        $product->category_id = $request->category_id;
        $product->user_id = auth()->user()->id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $image['name'];
        $product->color = $request->color;
        $product->fabric = $request->fabric;
        if ($product->title !== $request->title) {
            $slug = generateSlug($request->title);
            $product->slug = $slug;
        }
        $product->update();

        $product = new CatalogResource($product);
        return response()->json(['status' => 200, 'message' => 'Catalog updated successfully.', 'data' => $product]);
    }

}
