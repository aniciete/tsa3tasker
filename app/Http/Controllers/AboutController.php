<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the static About page identifying Charles Lawrence Aniciete.
     */
    public function index(): View
    {
        return view('about', [
            'title'      => 'About | Tasker',
            'activePage' => 'about',
        ]);
    }
}
