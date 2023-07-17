<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductImportController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('AdminPanel/Products/Import');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
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
}
