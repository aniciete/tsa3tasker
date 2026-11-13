@extends('layouts.app')

@section('content')
<section aria-labelledby="profile-heading">
    <div class="page-header">
        <div class="page-header-copy">
            <h1 id="profile-heading" class="page-title">Profile</h1>
            <p class="page-summary">
                Registered account details stored in the <code class="inline-code">users</code> table.
            </p>
        </div>
    </div>

    <div class="surface-panel">
        @if ($user)
            <dl class="definition-list" aria-label="User profile details">
                <div class="definition-row">
                    <dt class="definition-term">User ID</dt>
                    <dd class="definition-value definition-mono">#{{ $user->id }}</dd>
                </div>
                <div class="definition-row">
                    <dt class="definition-term">Username</dt>
                    <dd class="definition-value definition-mono">{{ $user->username }}</dd>
                </div>
                <div class="definition-row">
                    <dt class="definition-term">Full Name</dt>
                    <dd class="definition-value">{{ $user->full_name }}</dd>
                </div>
                <div class="definition-row">
                    <dt class="definition-term">Email Address</dt>
                    <dd class="definition-value">{{ $user->email }}</dd>
                </div>
                <div class="definition-row">
                    <dt class="definition-term">Created At</dt>
                    <dd class="definition-value definition-mono">
                        {{ $user->created_at?->format('Y-m-d H:i:s') ?? 'Not recorded' }}
                    </dd>
                </div>
            </dl>
        @else
            <x-empty-state
                title="No user profile is currently available."
                copy="Account details will display here once a profile record exists."
                :link-url="route('welcome')"
                link-label="Go to today's tasks"
            />
        @endif
    </div>
</section>
@endsection
