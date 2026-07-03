@extends('layouts.app')
@section('title', 'All Tenants')

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span></div>
        <nav>
            <a href="{{ route('central.home') }}">Home</a>
            <a href="{{ route('central.register') }}">Register Workspace</a>
        </nav>
    </div>
</div>

<section style="padding: 40px 0;">
    <div class="container">
        <div class="card">
            <h2>All Workspaces ({{ $tenants->total() }})</h2>
            <table>
                <thead>
                    <tr><th>Slug</th><th>Name</th><th>Domain</th><th>Status</th><th>Created</th><th>Open</th></tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $t)
                        <tr>
                            <td><code>{{ $t->id }}</code></td>
                            <td>{{ $t->name }}</td>
                            <td><code>{{ $t->domains->first()?->domain ?? '—' }}</code></td>
                            <td>
                                @if ($t->is_active)
                                    <span class="badge badge-done">active</span>
                                @else
                                    <span class="badge badge-pending">inactive</span>
                                @endif
                            </td>
                            <td>{{ $t->created_at?->format('Y-m-d H:i') }}</td>
                            <td><a href="{{ $t->url() }}/login" class="btn btn-sm btn-outline">Open →</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:var(--muted);">No tenants yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $tenants->withQueryString()->links() }}</div>
        </div>
    </div>
</section>
@endsection
