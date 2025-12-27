<?php

namespace HarlequinSin\AutoContainerLabels\Listeners;

use App\Models\Server;
use HarlequinSin\AutoContainerLabels\Models\ContainerLabelTemplate;
use Illuminate\Support\Facades\Cache;

class ApplyContainerLabels
{
    public static function handle(Server $server): void
    {
        $templates = Cache::remember('container_label_templates_all', now()->addMinutes(5), function () {
            return ContainerLabelTemplate::all();
        });

        $labels = [];

        foreach ($templates as $template) {
            $labels[$template->key] = $template->renderValue($server);
        }

        $existingLabels = json_decode($server->docker_labels ?? '{}', true) ?: [];
        $mergedLabels = array_merge($existingLabels, $labels);

        if ($mergedLabels !== $existingLabels) {
            $server->docker_labels = json_encode($mergedLabels);
            $server->saveQuietly();
        }
    }
}
