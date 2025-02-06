<?php

/**
 * Node Resource for Filament Admin Panel
 *
 * This class represents a resource for managing Node models in the Filament admin panel.
 * It provides functionality for listing, creating, editing, and viewing nodes in an
 * infrastructure hierarchy.
 *
 * @package Crumbls\Infrastructure\Filament\Resources
 */
namespace Crumbls\Infrastructure\Filament\Resources;

use Crumbls\Infrastructure\Filament\Resources\Pages\InfrastructureMap;
use Crumbls\Infrastructure\Models\Node;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;

/**
 * NodeResource Class
 *
 * Extends the base Filament Resource class to manage Node entities
 * within the infrastructure system.
 */
class NodeResource extends Resource {
    /**
     * The model class this resource corresponds to
     *
     * @var string|null
     */
    protected static ?string $model = Node::class;

    /**
     * The icon to be displayed in the navigation menu
     * Uses Heroicons outline rectangle stack icon
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get the navigation group name for this resource
     * Inherits grouping from InfrastructureMap
     *
     * @return string|null
     */
    public static function getNavigationGroup(): ?string {
        return InfrastructureMap::getNavigationGroup();
    }

    /**
     * Get the navigation label for this resource
     * Retrieves the translated string for plural form of nodes
     *
     * @return string
     */
    public static function getNavigationLabel(): string {
        return trans('infrastructure::infrastructure.nodes.plural');
    }

    /**
     * Get the sort order for this resource in the navigation menu
     * Positions this item 10 slots after the InfrastructureMap
     *
     * @return int|null
     */
    public static function getNavigationSort(): ?int {
        return InfrastructureMap::getNavigationSort() + 10;
    }

    /**
     * Define the form schema for creating and editing nodes
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->options([
                        'server' => 'Server',
                        'database' => 'Database',
                        'site' => 'Site'
                    ])
                    ->required()
                    ->disabled(fn ($record) => $record !== null),

                Select::make('status')
                    ->options([
                        'operational' => 'Operational',
                        'warning' => 'Warning',
                        'error' => 'Error',
                        'maintenance' => 'Maintenance'
                    ])
                    ->required(),

                Select::make('parents')
                    ->multiple()
                    ->relationship('parents', 'name')
                    ->preload()
                    ->searchable()
            ]);
    }

    /**
     * Define the table schema for displaying nodes
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
            ])
            ->defaultSort('_lft')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get the relative path components for this resource
     *
     * @return array
     */
    public static function getRelativePathComponents(): array {
        return ['infrastructure', 'nodes'];
    }

    /**
     * Define the pages available for this resource
     *
     * @return array
     */
    public static function getPages(): array {
        return [
            'index' => Pages\ListNodes::route('/'),
            'create' => Pages\CreateNode::route('/create'),
            'edit' => Pages\EditNode::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the base Eloquent query for this resource
     * Applies default ordering to the query
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->defaultOrder();
    }

    /**
     * Define the widgets available for this resource
     *
     * @return array
     */
    public static function getWidgets(): array {
        return [
        ];
    }
}
