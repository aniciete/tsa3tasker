<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed sample tasks spanning 4 dates (yesterday, today, tomorrow, +2 days).
     */
    public function run(): void
    {
        $today = now()->startOfDay();

        $tasks = [
            [
                'title' => 'Buy groceries (milk, eggs, and bread)',
                'status' => TaskStatus::Pending,
                'task_date' => $today->toDateString(),
            ],
            [
                'title' => 'Morning 30-minute jog in the park',
                'status' => TaskStatus::Completed,
                'task_date' => $today->toDateString(),
            ],
            [
                'title' => 'Water the indoor plants',
                'status' => TaskStatus::Completed,
                'task_date' => $today->toDateString(),
            ],
            [
                'title' => 'Prepare dinner and wash the dishes',
                'status' => TaskStatus::Pending,
                'task_date' => $today->toDateString(),
            ],
            [
                'title' => 'Do laundry and fold clothes',
                'status' => TaskStatus::Completed,
                'task_date' => $today->copy()->subDay()->toDateString(),
            ],
            [
                'title' => 'Take out the trash and recycling bins',
                'status' => TaskStatus::Completed,
                'task_date' => $today->copy()->subDay()->toDateString(),
            ],
            [
                'title' => 'Clean the kitchen counters and vacuum living room',
                'status' => TaskStatus::Completed,
                'task_date' => $today->copy()->subDay()->toDateString(),
            ],
            [
                'title' => 'Pay monthly electric and water bills',
                'status' => TaskStatus::Pending,
                'task_date' => $today->copy()->addDay()->toDateString(),
            ],
            [
                'title' => 'Schedule dentist checkup appointment',
                'status' => TaskStatus::Pending,
                'task_date' => $today->copy()->addDay()->toDateString(),
            ],
            [
                'title' => 'Wash the car and check tire pressure',
                'status' => TaskStatus::Pending,
                'task_date' => $today->copy()->addDays(2)->toDateString(),
            ],
        ];

        foreach ($tasks as $task) {
            Task::query()->firstOrCreate(
                [
                    'title' => $task['title'],
                    'task_date' => $task['task_date'],
                ],
                [
                    'status' => $task['status'],
                ]
            );
        }
    }
}
