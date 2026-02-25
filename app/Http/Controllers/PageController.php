<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(string $page)
    {
        // Белый список, чтобы не отдавать произвольные шаблоны
        $allowed = [
            'about',
            'obuchenie',
            'document',
            'contacts',
            'modern',
            'modern_dron',
            'programs',
            'systems',
            'center',
        ];

        abort_unless(in_array($page, $allowed, true), 404);

        return view("pages.$page");
    }
}
