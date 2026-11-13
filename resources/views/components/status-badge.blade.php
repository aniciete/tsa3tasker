@props(['status' => \App\Enums\TaskStatus::Pending])

@php
    $value = $status instanceof \App\Enums\TaskStatus ? $status->value : strtolower((string) $status);
    $isCompleted = $value === \App\Enums\TaskStatus::Completed->value;
@endphp

<span class="status-badge {{ $isCompleted ? 'status-completed' : 'status-pending' }}">
    @if ($isCompleted)
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M3.5 8.5L6.5 11.5L12.5 5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @else
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.75"/>
            <path d="M8 5.25V8.25L10 9.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @endif
    <span>{{ $value }}</span>
</span>
