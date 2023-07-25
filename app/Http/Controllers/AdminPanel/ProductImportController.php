<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('AdminPanel/Products/Import');
    }


    public function store(Request $request)
    {
        // ProductImportRequest
        $file = $request->file('file')->getPathname();

        Excel::import(new ProductsImport, $file);

        return redirect()->back()->with('success', 'Products successfully imported');
    }
}


// public function store(Request $request): RedirectResponse
// {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|file|mimes:xlsx,csv',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator);
    //     }

    //     $file = $request->file('file')->getPathname();

    //     try {
    //         // Use import() method instead of queueImport()
    //         Excel::import(new ProductsImport, $file);
    //         return redirect()->back()->with('success', 'Products successfully imported');
    //     } catch (ValidationException $e) {
    //         $failures = $e->failures();
    //         return redirect()->back()->with('import_errors', $failures);
    //     }
// }

// public function store(Request $request): RedirectResponse
// {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|file|mimes:xlsx,csv',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator);
    //     }

    //     $file = $request->file('file')->getPathname();

    //     try {
// Excel::queueImport(new ProductsImport, $file);
    //         Excel::import(new ProductsImport, $file);
    //         return redirect()->back()->with('success', 'Products successfully imported');
    //     } catch (ValidationException $e) {
    //         $failures = $e->failures();

    //         return redirect()->back()->with('import_errors', $failures);
    //     }
// }
// }

// namespace App\Http\Controllers\AdminPanel;

// use App\Http\Controllers\Controller;
// use App\Imports\ProductsImport;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Inertia\Inertia;
// use Inertia\Response;
// use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Validators\ValidationException;

// class ProductImportController extends Controller
// {
//     public function show(): Response
//     {
//         return Inertia::render('AdminPanel/Products/Import');
//     }

//     public function store(Request $request): RedirectResponse
//     {
//         $request->validate([
//             'file' => 'required|file|mimes:xlsx,csv',
//         ]);

//         $file = $request->file('file')->getPathname();

//         try {
//             Excel::queueImport(new ProductsImport, $file);

//             return redirect()->back()->with('success', 'Products successfully imported');
//         } catch (ValidationException $e) {
//             $failures = $e->failures();

//             return redirect()->back()->with('import_errors', $failures);
//         }
//     }
// }
