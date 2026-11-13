@extends('layouts.app')

@section('content')
<section aria-labelledby="about-heading">
    <div class="page-header">
        <div class="page-header-copy">
            <h1 id="about-heading" class="page-title">About Tasker</h1>
            <p class="page-summary">
                Personal task management assistant built with Laravel 13 by <strong>Charles Lawrence Aniciete</strong>.
            </p>
        </div>
    </div>

    <div class="surface-panel">
        <div class="about-body">
            <div class="about-section">
                <h2 class="section-heading">Project Overview</h2>
                <p class="about-prose">
                    Tasker is the Laravel implementation of the Tasks for Today Management System for IT0049 Technical Summative Assessment 3 (TSA3), developed by Charles Lawrence Aniciete. It preserves the schema, sample data, and page responsibilities of TSA1 while replacing raw SQL and Query Builder calls with Laravel migrations, seeders, and Eloquent ORM models.
                </p>
            </div>

            <div class="about-section">
                <h2 class="section-heading">Models &amp; Query Scopes</h2>
                <p class="about-prose">
                    Task retrieval is encapsulated in <code class="inline-code">App\Models\Task</code> using local Eloquent query scopes (<code class="inline-code">forToday()</code> and <code class="inline-code">orderedByDate()</code>), while profile display queries <code class="inline-code">App\Models\User</code> directly from the database.
                </p>
            </div>
        </div>

        <dl class="definition-list">
            <div class="definition-row">
                <dt class="definition-term">Developer</dt>
                <dd class="definition-value">Charles Lawrence Aniciete</dd>
            </div>
            <div class="definition-row">
                <dt class="definition-term">Framework</dt>
                <dd class="definition-value">Laravel 13 &amp; Eloquent ORM</dd>
            </div>
            <div class="definition-row">
                <dt class="definition-term">Routes</dt>
                <dd class="definition-value definition-mono">/, /tasks, /profile, /about</dd>
            </div>
        </dl>
    </div>
</section>
@endsection
