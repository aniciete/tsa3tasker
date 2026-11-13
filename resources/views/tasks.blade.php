@extends('layouts.app')

@section('content')
<section aria-labelledby="all-tasks-heading">
    <div class="page-header">
        <div class="page-header-copy">
            <h1 id="all-tasks-heading" class="page-title">All Tasks</h1>
            <p class="page-summary">
                <span class="summary-count">{{ $tasks->count() }} {{ \Illuminate\Support\Str::plural('task', $tasks->count()) }}</span>
                ordered chronologically by scheduled date.
            </p>
        </div>

        <a href="{{ route('welcome') }}" class="text-link">Back to today&rsquo;s tasks</a>
    </div>

    <div class="surface-panel">
        @if ($tasks->isNotEmpty())
            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Task</th>
                        <th scope="col">Scheduled Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="col-id" data-label="ID">#{{ $task->id }}</td>
                            <td class="task-title" data-label="Task">{{ $task->title }}</td>
                            <td class="col-date" data-label="Scheduled Date">
                                <time datetime="{{ $task->task_date->toDateString() }}" class="mono-date">
                                    {{ $task->task_date->toDateString() }}
                                </time>
                                @if ($task->task_date->isToday())
                                    <span class="date-marker">(Today)</span>
                                @endif
                            </td>
                            <td class="col-status" data-label="Status">
                                <x-status-badge :status="$task->status" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p class="empty-title">No tasks are currently recorded.</p>
                <p class="empty-copy">
                    Scheduled tasks will appear here chronologically once added.
                </p>
                <a href="{{ route('welcome') }}" class="text-link">Return to today&rsquo;s tasks</a>
            </div>
        @endif
    </div>
</section>
@endsection
