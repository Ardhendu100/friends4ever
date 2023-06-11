<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class PageBuilderController extends Controller
{
    public function index()
    {
        return View::make('page-builder');
    }

    public function save(Request $request)
    {
        $htmlContent = $request->input('htmlContent');

        // Handle saving the generated HTML as per your requirements

        return redirect('/page-builder')->with('success', 'HTML saved successfully.');
    }
}
