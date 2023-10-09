<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Mengatur guard yang digunakan oleh permission
        config()->set('permission.guard_name', 'web'); // Ubah 'web' dengan guard yang sesuai

        // Mengatur tipe role yang digunakan
        config()->set('permission.models.role', Role::class);

        // Mengatur tipe permission yang digunakan
        config()->set('permission.models.permission', Permission::class);
    }
}