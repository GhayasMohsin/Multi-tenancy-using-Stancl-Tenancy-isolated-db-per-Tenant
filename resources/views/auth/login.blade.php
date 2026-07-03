@extends('layouts.app')
@section('title', 'Sign in - ' . $tenant->name)

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span></div>
        <nav>
            <span class="tenant-tag">{{ $tenant->name }}</span>
        </nav>
    </div>
</div>

<section style="padding: 40px 0;">
    <div class="container" style="max-width:440px;">
        <div class="card">
            <h2>Sign in to {{ $tenant->name }}</h2>
            <p style="color:var(--muted); margin-bottom:20px; font-size:14px;">
                You are on the <code>{{ $tenant->id }}</code> workspace.
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus />
                    @error('email') <small style="color:var(--danger);">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; font-weight:400;">
                        <input type="checkbox" name="remember" style="width:auto;" /> Remember me
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
