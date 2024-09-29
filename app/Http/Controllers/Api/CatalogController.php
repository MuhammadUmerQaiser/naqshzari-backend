<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogCreateRequest;
use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    protected $catalog;
    function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function createCatalog(CatalogCreateRequest $request)
    {
        try {
            return $this->catalog->createCatalog($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updateCatalog(Request $request, $catalog)
    {
        try {
            return $this->catalog->updateCatalog($request, $catalog);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function deleteCatalog(Request $request, $catalog)
    {
        try {
            return $this->catalog->deleteCatalog($request, $catalog);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getAllCatalogs(Request $request)
    {
        try {
            return $this->catalog->getAllCatalogs($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getCatalogBySlug(Request $request, $slug)
    {
        try {
            return $this->catalog->getCatalogBySlug($request, $slug);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }
}
