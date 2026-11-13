@extends('layouts.app')

@section('content')
@php
    $totalToday = $tasks->count();
    $completedToday = $tasks->where('status', \App\Models\Task::STATUS_COMPLETED)->count();
    $pendingToday = $totalToday - $completedToday;
@endphp

<section aria-labelledby="today-heading">
    <div class="page-header">
        <div class="page-header-copy">
            <h1 id="today-heading" class="page-title">Tasks for Today</h1>
            <p class="page-summary">
                {{ $todayDate }} &mdash;
                <span class="summary-count">
                    @if ($totalToday > 0)
                        {{ $totalToday }} {{ \Illuminate\Support\Str::plural('task', $totalToday) }} scheduled ({{ $completedToday }} completed, {{ $pendingToday }} pending).
                    @else
                        No tasks scheduled for today.
                    @endif
                </span>
            </p>
        </div>

        <a href="{{ route('tasks.index') }}" class="text-link">View all tasks</a>
    </div>

    <div class="surface-panel">
        @if ($tasks->isNotEmpty())
            <ul class="task-list">
                @foreach ($tasks as $task)
                    <li class="task-row">
                        <span class="task-title">{{ $task->title }}</span>
                        <x-status-badge :status="$task->status" />
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <p class="empty-title">No tasks scheduled for today.</p>
                <p class="empty-copy">
                    Check the full schedule to review tasks assigned to past or upcoming dates.
                </p>
                <a href="{{ route('tasks.index') }}" class="text-link">Browse all tasks</a>
            </div>
        @endif
    </div>
</section>
@endsection
