<?php

namespace HarlequinSin\AutoContainerLabels\Models;

use App\Models\Server;
use Illuminate\Database\Eloquent\Model;

class ContainerLabelTemplate extends Model
{
    protected $table = 'container_label_templates';

    protected $fillable = [
        'key',
        'value',
    ];

    public function renderValue(Server $server): string
    {
        $map = [
            'uuid'       => (string) ($server->uuid ?? ''),
            'uuid_short' => (string) ($server->uuid_short ?? ''),
            'alias'      => (string) ($server->alias ?? ''),
            'name'       => (string) ($server->name ?? ''),
        ];

        return preg_replace_callback('/\$\{([a-z0-9_]+)\}/i', function ($matches) use ($map) {
            $key = strtolower($matches[1]);
            return $map[$key] ?? $matches[0];
        }, $this->value);
    }
}
