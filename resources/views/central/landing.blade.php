@extends('layouts.app')
@section('title', 'Multitenant Todo - One app, many workspaces')

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span></div>
        <nav>
            <a href="{{ route('central.tenants') }}">All Tenants</a>
            <a href="{{ route('central.register') }}">Register Workspace</a>
        </nav>
    </div>
</div>

<section class="hero">
    <div class="container">
        <h1>One app, many workspaces.</h1>
        <p>Multi-tenant todo management powered by <strong>stancl/tenancy</strong>. Each workspace lives on its own subdomain with a fully isolated database.</p>
        <div class="cta-group">
            <a class="btn btn-primary" href="{{ route('central.register') }}">Register a Workspace</a>
            <a class="btn btn-outline" href="{{ route('central.tenants') }}">Browse Tenants</a>
        </div>
    </div>
</section>

<section style="padding-bottom:60px;">
    <div class="container">
        @if ($tenants->isNotEmpty())
            <div class="card">
                <h2>Recent Workspaces</h2>
                <table>
                    <thead>
                        <tr><th>Slug</th><th>Name</th><th>Database</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($tenants as $t)
                            <tr>
                                <td><code>{{ $t->id }}</code></td>
                                <td>{{ $t->name }}</td>
                                <td><code>stancl_todo_{{ $t->id }}</code></td>
                                <td>
                                    @if ($t->is_active)
                                        <span class="badge badge-done">active</span>
                                    @else
                                        <span class="badge badge-pending">inactive</span>
                                    @endif
                                </td>
                                <td><a href="{{ $t->url() }}/login" class="btn btn-sm btn-outline">Open →</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card" style="text-align:center;">
                <p style="color:var(--muted); margin-bottom:20px;">No workspaces yet. Spin one up!</p>
                <a class="btn btn-primary" href="{{ route('central.register') }}">Create First Workspace</a>
            </div>
        @endif
    </div>
</section>
@endsection
