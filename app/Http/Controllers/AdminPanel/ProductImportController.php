<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function show()
    {
        return Inertia::render('AdminPanel/Products/Import');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new ProductsImport, $file);

        return redirect()->back();


        // return back()->with('import');
    }
}

//$file = $request->file('file')->store('import');
// $import = new ProductsImport;
// $import->import($file);

// if ($import->failures()->isNotEmpty()) {
        //     return back()->withFailures($import->failures());
// }


// return back()->withStatus('Import in queue, we will send notification after import finished.');
//   public function import(Request $request)
// {
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');

    //         Excel::import(new YourImportClass, $file);

    //         // Process the imported data as per your requirement

    //         return response()->json(['message' => 'Import successful']);
    //     }

    //     return response()->json(['error' => 'No file found']);
// }
