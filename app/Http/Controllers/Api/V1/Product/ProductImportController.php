<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Jobs\ProductImportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductImportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (empty($request->file('file'))) {
            return response()->json(['message' => 'A file is required'], 400);
        }

        $file = $request->file('file')->store('imports');

        dispatch(new ProductImportJob($file, $request->user()));

        return response()->json([
            'message' => 'The file was imported successfully',
        ]);
    }
}
