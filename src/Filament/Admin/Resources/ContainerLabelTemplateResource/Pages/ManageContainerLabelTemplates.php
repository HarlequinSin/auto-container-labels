<?php

namespace HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Filament\Actions\CreateAction;
use HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource;

class ManageContainerLabelTemplates extends ManageRecords
{
    protected static string $resource = ContainerLabelTemplateResource::class;
}
