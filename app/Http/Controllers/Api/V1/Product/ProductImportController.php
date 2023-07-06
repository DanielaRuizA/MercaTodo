<?php

namespace App\Http\Controllers\Api\V1\Product;

use Illuminate\Http\Request;
use App\Jobs\ProductImportJob;
use App\Http\Controllers\Controller;

class ProductImportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (empty($request->file('file'))) {
            return response()->json(['message' => 'A file is required'], 400);
        }

        $file = $request->file('file')->store('imports');

        dispatch(new ProductImportJob($file, $request->user()));

        return response()->json([
            'message' => 'The file was file was imported successfully'
        ]);
    }
}
