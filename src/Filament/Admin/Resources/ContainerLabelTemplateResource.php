<?php

namespace HarlequinSin\AutoContainerLabels\Filament\Admin\Resources;

use Closure;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource\Pages;
use HarlequinSin\AutoContainerLabels\Models\ContainerLabelTemplate;
use Illuminate\Database\Eloquent\Builder;

class ContainerLabelTemplateResource extends Resource
{
    protected static ?string $model = ContainerLabelTemplate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    public static function getNavigationLabel(): string
    {
        return __('auto-container-labels::strings.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('key')
                    ->label(__('auto-container-labels::strings.key'))
                    ->required()
                    ->rules(fn(Get $stateGetter, ?ContainerLabelTemplate $record): array => [
                        function (string $attribute, mixed $value, Closure $fail) use ($stateGetter, $record): void {
                            if (!is_string($value)) {
                                return;
                            }

                            $selectedEggIds = $stateGetter('eggs') ?? [];

                            $templatesWithSameKey = ContainerLabelTemplate::query()
                                ->where('key', $value)
                                ->when(
                                    $record,
                                    fn(Builder $query): Builder => $query->where('id', '!=', $record->getKey()),
                                );

                            $hasConflict = $selectedEggIds === []
                                ? $templatesWithSameKey->whereDoesntHave('eggs')->exists()
                                : $templatesWithSameKey
                                    ->whereHas('eggs', fn(Builder $query): Builder => $query->whereKey($selectedEggIds))
                                    ->exists();

                            if ($hasConflict) {
                                $fail($selectedEggIds === []
                                    ? __('auto-container-labels::strings.global_key_conflict')
                                    : __('auto-container-labels::strings.egg_key_conflict'));
                            }
                        },
                    ])
                    ->maxLength(255),
                Select::make('eggs')
                    ->label(__('auto-container-labels::strings.eggs'))
                    ->multiple()
                    ->relationship('eggs', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText(__('auto-container-labels::strings.egg_scope_help')),
                TextInput::make('value')
                    ->label(__('auto-container-labels::strings.value'))
                    ->required()
                    ->maxLength(255)
                    ->helperText(__('auto-container-labels::strings.container_label_variables')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->with('eggs'))
            ->selectable()
            ->columns([
                TextColumn::make('key')
                    ->label(__('auto-container-labels::strings.key')),
                TextColumn::make('egg_scope')
                    ->label(__('auto-container-labels::strings.eggs'))
                    ->getStateUsing(
                        fn(ContainerLabelTemplate $record): string => $record->eggs->isEmpty()
                            ? __('auto-container-labels::strings.all_eggs')
                            : $record->eggs->pluck('name')->join(', '),
                    ),
                TextInputColumn::make('value')
                    ->label(__('auto-container-labels::strings.value')),
                TextColumn::make('created_at')
                    ->label(__('auto-container-labels::strings.created'))
                    ->dateTime(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->label(__('auto-container-labels::strings.delete_selected_templates'))
                    ->modalHeading(__('auto-container-labels::strings.delete_selected_templates_heading'))
                    ->modalDescription(__('auto-container-labels::strings.delete_selected_templates_description')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContainerLabelTemplates::route('/'),
        ];
    }
}
