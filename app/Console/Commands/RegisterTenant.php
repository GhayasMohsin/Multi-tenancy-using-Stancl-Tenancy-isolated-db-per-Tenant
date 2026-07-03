<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class RegisterTenant extends Command
{
    protected $signature = 'tenant:register
                            {slug : Subdomain slug, e.g. acme}
                            {name : Workspace display name}
                            {admin_name : Admin user name}
                            {admin_email : Admin user email}
                            {admin_password : Admin user password}';

    protected $description = 'Register a new tenant (creates DB, runs migrations, seeds admin user).';

    public function handle(): int
    {
        $slug = $this->argument('slug');

        if (Tenant::find($slug)) {
            $this->error("Tenant slug '{$slug}' already exists.");
            return self::FAILURE;
        }

        $this->info("Registering tenant '{$slug}'...");

        try {
            $tenant = Tenant::create([
                'id'           => $slug,
                'name'         => $this->argument('name'),
                'is_active'    => true,
                'admin_name'   => $this->argument('admin_name'),
                'admin_email'  => $this->argument('admin_email'),
                'admin_password' => $this->argument('admin_password'),
            ]);

            $domain = $slug . '.' . config('tenancy.central_domains')[0];
            // $tenant->domains()->create(['domain' => $domain]);
            $tenant->domains()->create(['domain' => $slug]);

            $this->newLine();
            $this->info('✓ Tenant created:');
            $this->line("  ID       : {$tenant->id}");
            $this->line("  Name     : {$tenant->name}");
            $this->line("  Database : stancl_todo_{$slug}");
            $this->line("  Admin    : {$this->argument('admin_email')}");
            $this->line("  URL      : http://{$domain}/login");
            $this->newLine();
            $this->comment('Add to Acrylic DNS or hosts file:');
            $this->line("  127.0.0.1 {$domain}");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}