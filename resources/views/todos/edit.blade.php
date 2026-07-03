@extends('layouts.app')
@section('title', 'Edit Todo')

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span> · {{ $tenant->name }}</div>
        <nav>
            <a href="{{ route('todos.index') }}">← Back</a>
            <a href="{{ route('todos.show', $todo->id) }}">View</a>
        </nav>
    </div>
</div>

<section style="padding: 30px 0;">
    <div class="container" style="max-width:640px;">
        <div class="card">
            <h2>Edit Todo</h2>
            <form method="POST" action="{{ route('todos.update', $todo->id) }}">
                @csrf @method('PUT')
                @include('todos._form', ['todo' => $todo])
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('todos.show', $todo->id) }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
