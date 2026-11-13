<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskerTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_populates_expected_user_and_tasks_across_multiple_dates(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertSame(1, User::query()->count());
        $this->assertGreaterThanOrEqual(8, Task::query()->count());

        $distinctDates = Task::query()->distinct()->count('task_date');
        $this->assertGreaterThanOrEqual(3, $distinctDates);
        $this->assertGreaterThanOrEqual(1, Task::forToday()->count());
    }

    public function test_user_username_is_unique_and_task_status_defaults_to_pending(): void
    {
        $task = Task::query()->create([
            'title'     => 'Verify default status migration constraint',
            'task_date' => now()->toDateString(),
        ]);

        $freshTask = Task::query()->findOrFail($task->id);
        $this->assertSame(Task::STATUS_PENDING, $freshTask->status);

        User::query()->create([
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
            'email'     => 'charles@example.com',
        ]);

        $this->expectException(QueryException::class);

        User::query()->create([
            'username'  => 'charles',
            'full_name' => 'Duplicate Username',
            'email'     => 'duplicate@example.com',
        ]);
    }

    public function test_welcome_page_displays_only_todays_tasks(): void
    {
        $this->seed();

        $response = $this->get(route('welcome'));

        $response->assertOk();
        $response->assertSee('Tasks for Today');
        $response->assertSee('Buy groceries (milk, eggs, and bread)');
        $response->assertSee('Prepare dinner and wash the dishes');
        $response->assertDontSee('Do laundry and fold clothes');
        $response->assertDontSee('Pay monthly electric and water bills');
        $response->assertDontSee('Wash the car and check tire pressure');
    }

    public function test_welcome_page_displays_empty_state_when_no_tasks_for_today(): void
    {
        Task::query()->create([
            'title'     => 'Yesterday finished item',
            'status'    => Task::STATUS_COMPLETED,
            'task_date' => now()->subDay()->toDateString(),
        ]);

        $response = $this->get(route('welcome'));

        $response->assertOk();
        $response->assertSee('No tasks scheduled for today.');
        $response->assertDontSee('Yesterday finished item');
    }

    public function test_tasks_page_displays_all_tasks_ordered_chronologically_by_date(): void
    {
        $this->seed();

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSee('All Tasks');
        $response->assertSeeInOrder([
            'Do laundry and fold clothes',
            'Buy groceries (milk, eggs, and bread)',
            'Pay monthly electric and water bills',
            'Wash the car and check tire pressure',
        ]);
    }

    public function test_profile_page_displays_single_seeded_user_and_handles_empty_table(): void
    {
        $emptyResponse = $this->get(route('profile.index'));
        $emptyResponse->assertOk();
        $emptyResponse->assertSee('No user profile record found.');

        $this->seed();

        $response = $this->get(route('profile.index'));
        $response->assertOk();
        $response->assertSee('charles');
        $response->assertSee('Charles Lawrence Aniciete');
        $response->assertSee('charles@example.com');
    }

    public function test_about_page_identifies_charles_as_developer(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertSee('About Tasker');
        $response->assertSee('Charles Lawrence Aniciete');
        $response->assertSee('aria-current="page"', false);
    }
}
