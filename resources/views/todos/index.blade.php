@extends('layouts.app')
@section('title', 'Todo List - ' . $tenant->name)

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span> · {{ $tenant->name }}</div>
        <nav>
            <span class="tenant-tag">{{ $tenant->id }}</span>
            <a href="{{ route('todos.create') }}">+ New Todo</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:var(--muted); cursor:pointer; font-size:14px;">Sign Out</button>
            </form>
        </nav>
    </div>
</div>

<section style="padding: 30px 0;">
    <div class="container">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h2 style="margin:0;">My Todos</h2>
                <a href="{{ route('todos.create') }}" class="btn btn-primary btn-sm">+ New</a>
            </div>

            <form method="GET" class="filters">
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search title..." />
                <select name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending','in_progress','done'] as $s)
                        <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>{{ str_replace('_', ' ', $s) }}</option>
                    @endforeach
                </select>
                <select name="priority">
                    <option value="">All priorities</option>
                    @foreach (['low','medium','high'] as $p)
                        <option value="{{ $p }}" @selected(($filters['priority'] ?? '') === $p)>{{ $p }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline btn-sm">Filter</button>
                <a href="{{ route('todos.index') }}" class="btn btn-outline btn-sm">Clear</a>
            </form>

            @if ($todos->isNotEmpty())
                <table>
                    <thead>
                        <tr><th>Title</th><th>Priority</th><th>Status</th><th>Due</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($todos as $todo)
                            <tr>
                                <td>
                                    <a href="{{ route('todos.show', $todo->id) }}">{{ $todo->title }}</a>
                                    @if ($todo->due_date && $todo->due_date->isPast() && $todo->status !== 'done')
                                        <span class="badge badge-high" style="margin-left:6px;">overdue</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $todo->priority }}">{{ $todo->priority }}</span></td>
                                <td><span class="badge badge-{{ $todo->status }}">{{ str_replace('_', ' ', $todo->status) }}</span></td>
                                <td>{{ $todo->due_date?->format('Y-m-d H:i') ?? '—' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('todos.toggle', $todo->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-sm">
                                            {{ $todo->status === 'done' ? '↺ Reopen' : '✓ Done' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('todos.destroy', $todo->id) }}" style="display:inline;"
                                          onsubmit="return confirm('Delete this todo?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">{{ $todos->links() }}</div>
            @else
                <div style="text-align:center; padding:40px 0; color:var(--muted);">
                    <p style="margin-bottom:20px;">No todos found.</p>
                    <a href="{{ route('todos.create') }}" class="btn btn-primary">Create your first todo</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
