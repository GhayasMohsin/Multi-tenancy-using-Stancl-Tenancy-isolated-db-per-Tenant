<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public $incrementing = false;
    protected $keyType = 'string';

    public static function getCustomColumns(): array
    {
        return ['id', 'name', 'is_active'];
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function url(): string
    {
        $domain = $this->domains->first()?->domain
            ?? ($this->id . '.' . config('tenancy.central_domains')[0]);

        return request()->getScheme() . '://' . $domain;
    }
}