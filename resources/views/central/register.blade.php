@extends('layouts.app')
@section('title', 'Register Workspace')

@section('content')
<div class="navbar">
    <div class="container">
        <div class="brand">Multi<span>Todo</span></div>
        <nav>
            <a href="{{ route('central.home') }}">Home</a>
            <a href="{{ route('central.tenants') }}">All Tenants</a>
        </nav>
    </div>
</div>

<section style="padding: 40px 0;">
    <div class="container" style="max-width:560px;">
        <div class="card">
            <h2>Register a Workspace</h2>
            <p style="color:var(--muted); margin-bottom:20px; font-size:14px;">
                Pick a slug — your workspace will live at <code>&lt;slug&gt;.{{ config('tenancy.central_domains')[0] }}</code>.
                Each tenant receives an isolated MySQL database.
            </p>

            <form method="POST" action="{{ route('central.store') }}">
                @csrf

                <div class="form-group">
                    <label for="slug">Workspace slug (subdomain)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="e.g. acme" required pattern="[a-z0-9\-]{3,63}" />
                    @error('slug') <small style="color:var(--danger);">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="name">Workspace name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Acme Corp" required />
                    @error('name') <small style="color:var(--danger);">{{ $message }}</small> @enderror
                </div>

                <hr style="border:none; border-top:1px solid var(--border); margin:20px 0;" />
                <h3 style="font-size:15px; margin-bottom:12px;">Admin User</h3>

                <div class="form-group">
                    <label for="admin_name">Admin name</label>
                    <input type="text" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required />
                </div>

                <div class="form-group">
                    <label for="admin_email">Admin email</label>
                    <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required />
                </div>

                <div class="form-group">
                    <label for="admin_password">Password</label>
                    <input type="password" id="admin_password" name="admin_password" required />
                </div>

                <div class="form-group">
                    <label for="admin_password_confirmation">Confirm password</label>
                    <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" required />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Workspace</button>
                    <a href="{{ route('central.home') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
