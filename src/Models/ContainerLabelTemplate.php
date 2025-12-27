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
        return preg_replace_callback('/\$\{([a-z0-9_]+)\}/i', function ($matches) use ($server) {
            $key = strtolower($matches[1]);
            
            $value = $server->getAttribute($key);
            if ($value !== null) {
                return (string) $value;
            }

            if ($key === 'alias') {
                // Attempt to get alias from primary allocation
                if (! empty($server->allocation_id)) {
                    $allocation = $server->allocations()->where('id', $server->allocation_id)->first();
                    if ($allocation && isset($allocation->alias)) {
                        return (string) $allocation->alias;
                    }
                }
            }

            // Unknown variable — leave placeholder intact
            return $matches[0];
        }, $this->value);
    }
}
