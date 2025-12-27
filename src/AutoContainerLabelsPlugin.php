<?php

namespace HarlequinSin\AutoContainerLabels;

use Filament\Contracts\Plugin;
use Filament\Panel;

class AutoContainerLabelsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'auto-container-labels';
    }

    public function register(Panel $panel): void
    {
        $id = str($panel->getId())->title();

        $panel->discoverResources(plugin_path($this->getId(), "src/Filament/$id/Resources"), "HarlequinSin\\AutoContainerLabels\\Filament\\$id\\Resources");
    }

    public function boot(Panel $panel): void {}
}
