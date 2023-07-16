<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Http\RedirectResponse;

class ProductImportController extends Controller
{
    public function show():Response
    {
        return Inertia::render('AdminPanel/Products/Import');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        $file = $request->file('file')->getPathname();

        try {
            Excel::queueImport(new ProductsImport, $file);
            return redirect()->back()->with('success', 'Products successfully imported');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('import_errors', $failures);
        }
    }

    // public function store(Request $request):RedirectResponse
    // {
    //     $file = $request->file('file');

    //     // $file = $request->validate([
    //     //     'file'=> 'required|file|mimes:xlsx,csv'
    //     // ]);

    //     Excel::queueImport(new ProductsImport, $file);
    //     // Excel::import(new ProductsImport, $file);


    //     return redirect()->back()->with('success', 'Products successfully imported');
    // }

    
    //   public function store(Request $request):RedirectResponse
    //   {
    //       $file = $request->file('file');

    //       Excel::import(new ProductsImport, $file);

    //       return redirect()->back();


    //       // return back()->with('import');
    //   }
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


// try {
        //     Excel::queueImport(new ProductsImport, $file);
        //     return redirect()->back()->with('success', 'Products successfully imported');
// } catch (ValidationException $e) {
        //     $failures = $e->failures();
        //     dd($failures);
        //     return redirect()->back()->with('import_errors', $failures);
// foreach ($failures as $failure) {
            //     $failure->row(); // row that went wrong
            //     $failure->attribute(); // either heading key (if using heading row concern) or column index
            //     $failure->errors(); // Actual error messages from Laravel validator
            //     $failure->values(); // The values of the row that has failed.
// }
// }
