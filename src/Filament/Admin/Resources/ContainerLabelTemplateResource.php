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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use HarlequinSin\AutoContainerLabels\Models\ContainerLabelTemplate;
use App\Models\Server;
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
                TextInput::make('key')
                    ->required()
                    ->unique(ContainerLabelTemplate::class, 'key', fn ($record) => $record)
                    ->maxLength(255),
                TextInput::make('value')
                    ->required()
                    ->helperText(__('auto-container-labels::strings.container_label_variables'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Key'),
                TextInputColumn::make('value')
                    ->label('Value'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime(),
            ])
            ->actions([
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
