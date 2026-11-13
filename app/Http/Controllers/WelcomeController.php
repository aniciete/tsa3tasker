<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Display tasks scheduled for today's date via the Eloquent Task model.
     */
    public function index(): View
    {
        $tasks = Task::forToday()->orderBy('id')->get();

        return view('welcome', [
            'title' => 'Welcome to Tasker',
            'activePage' => 'welcome',
            'todayDate' => now()->format('F j, Y'),
            'tasks' => $tasks,
        ]);
    }
}
