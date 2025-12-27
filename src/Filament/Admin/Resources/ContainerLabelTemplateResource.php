<?php

namespace HarlequinSin\AutoContainerLabels\Filament\Admin\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\IconSize;
use HarlequinSin\AutoContainerLabels\Models\ContainerLabelTemplate;
use HarlequinSin\AutoContainerLabels\Filament\Admin\Resources\ContainerLabelTemplateResource\Pages;

class ContainerLabelTemplateResource extends Resource
{
    protected static ?string $model = ContainerLabelTemplate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Container Label Templates';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ContainerLabelTemplate::class, 'key', fn ($record) => $record)
                    ->maxLength(255),

                Forms\Components\Textarea::make('value')
                    ->required()
                    ->rows(3)
                    ->helperText(__('auto-container-labels::strings.container_label_variable_help')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Key')->searchable(),
                Tables\Columns\TextColumn::make('value')->label('Value')->limit(60),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->icon('tabler-tag-plus')
                    ->hiddenLabel()
                    ->iconButton()
                    ->iconSize(IconSize::ExtraLarge),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContainerLabelTemplates::route('/'),
        ];
    }
}
