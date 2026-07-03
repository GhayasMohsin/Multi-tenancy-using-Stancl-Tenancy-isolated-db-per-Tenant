<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CentralController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::with('domains')->latest()->limit(10)->get();
        return view('central.landing', ['tenants' => $tenants]);
    }

    public function create(): View
    {
        return view('central.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'                   => ['required', 'string', 'min:3', 'max:63', 'regex:/^[a-z0-9\-]+$/'],
            'name'                   => ['required', 'string', 'max:255'],
            'admin_name'             => ['required', 'string', 'max:120'],
            'admin_email'            => ['required', 'email', 'max:255'],
            'admin_password'         => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (Tenant::find($data['slug'])) {
            return back()->withInput()->with('error', "Slug '{$data['slug']}' already exists.");
        }

        try {
            $tenant = Tenant::create([
                'id'             => $data['slug'],
                'name'           => $data['name'],
                'is_active'      => true,
                'admin_name'     => $data['admin_name'],
                'admin_email'    => $data['admin_email'],
                'admin_password' => $data['admin_password'],
            ]);

            $tenant->domains()->create([
                'domain' => $data['slug'],
            ]);
            // $tenant->domains()->create([
            //     'domain' => $data['slug'] . '.' . config('tenancy.central_domains')[0],
            // ]);

            $scheme = $request->getScheme();
            $domain = $data['slug'] . '.' . config('tenancy.central_domains')[0];

            return redirect("{$scheme}://{$domain}/login")
                ->with('success', "Workspace '{$tenant->name}' created. You can log in now.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function tenants(): View
    {
        $tenants = Tenant::with('domains')->latest()->paginate(20);
        return view('central.tenants', ['tenants' => $tenants]);
    }
}
