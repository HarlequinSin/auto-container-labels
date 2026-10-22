<?php

namespace HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\IconSize;
use HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource;

class ManageContainerLabelTemplates extends ManageRecords
{
    protected static string $resource = ContainerLabelTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('auto-container-labels::strings.create_template'))
                ->icon('tabler-tag-plus')
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge),
        ];
    }
}
