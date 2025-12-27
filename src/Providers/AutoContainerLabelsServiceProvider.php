<?php

namespace HarlequinSin\AutoContainerLabels\Providers;

use App\Models\Role;
use App\Models\Server;
use HarlequinSin\AutoContainerLabels\Listeners\ApplyContainerLabels;
use Illuminate\Support\ServiceProvider;

class AutoContainerLabelsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Role::registerCustomDefaultPermissions('auto_container_labels');
        Role::registerCustomModelIcon('auto_container_labels', 'tabler-tag-plus');
    }

    public function boot(): void
    {
        // Load plugin translations so Filament helper text works
        $this->loadTranslationsFrom(plugin_path('auto-container-labels', 'lang'), 'auto-container-labels');

        // Apply templates to servers when they are created
        Server::created([ApplyContainerLabels::class, 'handle']);
    }
}
