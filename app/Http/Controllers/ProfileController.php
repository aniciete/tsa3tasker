<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the single seeded user record from the users table.
     */
    public function index(): View
    {
        $user = User::query()->orderBy('id')->first();

        return view('profile', [
            'title'      => 'Profile | Tasker',
            'activePage' => 'profile',
            'user'       => $user,
        ]);
    }
}
