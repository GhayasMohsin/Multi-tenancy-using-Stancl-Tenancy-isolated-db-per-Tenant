@extends('layouts.app')
@section('title', $todo->title)

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span> · {{ $tenant->name }}</div>
        <nav>
            <a href="{{ route('todos.index') }}">← Back</a>
            <a href="{{ route('todos.edit', $todo->id) }}">Edit</a>
        </nav>
    </div>
</div>

<section style="padding: 30px 0;">
    <div class="container" style="max-width:760px;">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                <h2 style="margin:0;">{{ $todo->title }}</h2>
                <span class="badge badge-{{ $todo->status }}">{{ str_replace('_', ' ', $todo->status) }}</span>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <small style="color:var(--muted);">Priority</small>
                    <div><span class="badge badge-{{ $todo->priority }}">{{ $todo->priority }}</span></div>
                </div>
                <div>
                    <small style="color:var(--muted);">Due Date</small>
                    <div>{{ $todo->due_date?->format('Y-m-d H:i') ?? '—' }}</div>
                </div>
                <div>
                    <small style="color:var(--muted);">Created</small>
                    <div>{{ $todo->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div>
                    <small style="color:var(--muted);">Completed</small>
                    <div>{{ $todo->completed_at?->format('Y-m-d H:i') ?? '—' }}</div>
                </div>
            </div>

            @if ($todo->notes)
                <div>
                    <small style="color:var(--muted);">Notes</small>
                    <div style="margin-top:6px; white-space:pre-wrap; padding:12px; background:var(--bg); border-radius:8px;">{{ $todo->notes }}</div>
                </div>
            @endif

            <div class="form-actions" style="margin-top:24px;">
                <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-primary">Edit</a>
                <form method="POST" action="{{ route('todos.toggle', $todo->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        {{ $todo->status === 'done' ? '↺ Reopen' : '✓ Mark Done' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('todos.destroy', $todo->id) }}"
                      onsubmit="return confirm('Delete this todo?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
