<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductImportController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('AdminPanel/Products/Import');
    }


    public function store(Request $request)
    {
        $request->validate([
        'file' => 'required|file|mimes:xlsx',
    ]);

        $file = $request->file('file')->getPathname();

        try {
            Excel::queueImport(new ProductsImport, $file);
            return redirect()->back()->with('success', 'Products Was Successfully Imported');
        } catch (ValidationException $e) {
            $failures = $e->validator->getMessageBag()->toArray();
            return redirect()->back()->with('import_errors', $failures);
        }
    }
}
