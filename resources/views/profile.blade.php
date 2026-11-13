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
            <dl class="definition-list">
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
            <div class="empty-state">
                <p class="empty-title">No user profile record found.</p>
                <p class="empty-copy">
                    Seed the database using <code class="inline-code">php artisan db:seed</code> to populate the profile record.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
