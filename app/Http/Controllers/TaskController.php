<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display all seeded tasks ordered chronologically by task_date.
     */
    public function index(): View
    {
        $tasks = Task::orderedByDate()->get();

        return view('tasks', [
            'title' => 'All Tasks | Tasker',
            'activePage' => 'tasks',
            'tasks' => $tasks,
        ]);
    }
}
