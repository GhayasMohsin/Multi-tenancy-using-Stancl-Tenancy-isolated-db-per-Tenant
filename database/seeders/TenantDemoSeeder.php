<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() === 0) {
            $tenant = tenancy()->tenant;

            $name     = $tenant?->admin_name     ?? 'Demo Admin';
            $email    = $tenant?->admin_email    ?? 'admin@demo.test';
            $password = $tenant?->admin_password ?? 'secret123';

            User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
            ]);
        }

        $user = User::first();
        if (! $user || Todo::count() > 0) {
            return;
        }

        Todo::insert([
            [
                'user_id'      => $user->id,
                'title'        => 'Set up stancl/tenancy multitenancy',
                'notes'        => 'Subdomain isolation, per-tenant DB, no FE framework.',
                'priority'     => 'high',
                'status'       => 'done',
                'completed_at' => now(),
                'due_date'     => now()->subDay(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => $user->id,
                'title'        => 'Write README with demo steps',
                'notes'        => null,
                'priority'     => 'medium',
                'status'       => 'in_progress',
                'completed_at' => null,
                'due_date'     => now()->addDays(2),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => $user->id,
                'title'        => 'Add tests for tenant middleware',
                'notes'        => 'Cover InitializeTenancyBySubdomain.',
                'priority'     => 'low',
                'status'       => 'pending',
                'completed_at' => null,
                'due_date'     => now()->addWeek(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}