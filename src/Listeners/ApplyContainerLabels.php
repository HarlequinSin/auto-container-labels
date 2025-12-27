<?php

namespace HarlequinSin\AutoContainerLabels\Listeners;

use App\Models\Server;
use HarlequinSin\AutoContainerLabels\Models\ContainerLabelTemplate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApplyContainerLabels
{
    public static function handle(Server $server): void
    {
        $templates = ContainerLabelTemplate::all();

        $labels = [];

        foreach ($templates as $template) {
            $labels[$template->key] = $template->renderValue($server);
        }

        $existingLabels = [];

        if (is_string($server->docker_labels)) {
            $existingLabels = json_decode($server->docker_labels, true) ?: [];
        } elseif (is_array($server->docker_labels)) {
            $existingLabels = $server->docker_labels;
        } else {
            $existingLabels = [];
        }

        $mergedLabels = array_merge($existingLabels, $labels);

        if ($mergedLabels !== $existingLabels) {
            $server->docker_labels = $mergedLabels;
            $server->saveQuietly();
        }
    }
}
