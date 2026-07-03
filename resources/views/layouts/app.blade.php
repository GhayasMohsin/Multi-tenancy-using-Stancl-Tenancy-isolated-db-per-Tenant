<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Multitenant Todo')</title>
    <style>
        :root {
            --primary: #2563eb; --primary-dark: #1d4ed8;
            --bg: #f8fafc; --card: #ffffff;
            --text: #0f172a; --muted: #64748b; --border: #e2e8f0;
            --success: #16a34a; --danger: #dc2626;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; min-height: 100vh; }
        a { color: var(--primary); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 1080px; margin: 0 auto; padding: 0 20px; }
        .navbar { background: var(--card); border-bottom: 1px solid var(--border); padding: 14px 0; position: sticky; top: 0; z-index: 10; }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; }
        .navbar .brand { font-weight: 700; font-size: 18px; color: var(--text); }
        .navbar .brand span { color: var(--primary); }
        .navbar nav a { margin-left: 20px; color: var(--muted); font-size: 14px; }
        .navbar nav a:hover { color: var(--primary); text-decoration: none; }
        .navbar .tenant-tag { background: #eff6ff; color: var(--primary-dark); padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .hero { padding: 60px 0 40px; text-align: center; }
        .hero h1 { font-size: 36px; font-weight: 700; margin-bottom: 12px; }
        .hero p { color: var(--muted); font-size: 18px; max-width: 640px; margin: 0 auto 28px; }
        .hero .cta-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid transparent; cursor: pointer; text-decoration: none; transition: background .15s; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); text-decoration: none; }
        .btn-outline { background: transparent; border-color: var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); text-decoration: none; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #b91c1c; text-decoration: none; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 24px; margin-bottom: 20px; }
        .card h2 { font-size: 20px; margin-bottom: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
        .form-actions { display: flex; gap: 12px; align-items: center; margin-top: 8px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
        .badge-low { background: #d1fae5; color: #065f46; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-high { background: #fee2e2; color: #991b1b; }
        .badge-pending { background: #e0e7ff; color: #3730a3; }
        .badge-in_progress { background: #fef3c7; color: #92400e; }
        .badge-done { background: #dcfce7; color: #166534; }
        .filters { display: flex; gap: 8px; align-items: center; margin-bottom: 16px; flex-wrap: wrap; }
        .filters select, .filters input { padding: 8px 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; }
        .pagination { margin-top: 20px; display: flex; gap: 4px; }
        .pagination a, .pagination span { padding: 6px 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; }
        .pagination .active { background: var(--primary); color: #fff; border-color: var(--primary); }
    </style>
    @stack('styles')
</head>
<body>

@if (session('success'))
    <div class="container" style="margin-top:16px;">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
@endif
@if (session('error'))
    <div class="container" style="margin-top:16px;">
        <div class="alert alert-error">{{ session('error') }}</div>
    </div>
@endif

@yield('content')

@stack('scripts')
</body>
</html>
