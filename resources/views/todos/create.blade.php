@extends('layouts.app')
@section('title', 'New Todo')

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span> · {{ $tenant->name }}</div>
        <nav><a href="{{ route('todos.index') }}">← Back</a></nav>
    </div>
</div>

<section style="padding: 30px 0;">
    <div class="container" style="max-width:640px;">
        <div class="card">
            <h2>New Todo</h2>
            <form method="POST" action="{{ route('todos.store') }}">
                @csrf
                @include('todos._form', ['todo' => null])
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('todos.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
