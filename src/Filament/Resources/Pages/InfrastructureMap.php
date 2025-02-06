<?php

/**
 * Infrastructure Map Page Resource for Filament Admin Panel
 *
 * This class represents a custom page in the Filament admin panel
 * that displays an infrastructure map view.
 *
 * @package Crumbls\Infrastructure\Filament\Resources\Pages
 */
namespace Crumbls\Infrastructure\Filament\Resources\Pages;

use Crumbls\Infrastructure\Models\Node;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

/**
 * InfrastructureMap Class
 *
 * Extends the base Filament Page class to create a custom map view
 * for infrastructure-related data.
 */
class InfrastructureMap extends Page
{
    /**
     * The icon to be displayed in the navigation menu
     * Uses Heroicons outline map icon
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-map';

    /**
     * The view file path for rendering this page
     * Points to a blade template in the infrastructure package
     *
     * @var string
     */
    protected static string $view = 'infrastructure::filament.resources.pages.infrastructure-map';

    public ?Collection $nodes = null;

    public ?Collection $edges = null;


    /**
     * Get the navigation group name for this page
     * Retrieves the translated string from the infrastructure language file
     *
     * @return string
     */
    public static function getNavigationGroup(): string
    {
        return trans('infrastructure::infrastructure.navigation');
    }

    /**
     * Get the navigation label for this page
     * Retrieves the translated string for the map label
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return trans('infrastructure::infrastructure.map.title');
    }

    /**
     * Get the sort order for this page in the navigation menu
     * Returns 50 to position this item in the middle of the navigation
     *
     * @return int|null
     */
    public static function getNavigationSort(): ?int
    {
        return 50;
    }

    /**
     * Determine if this page should be registered in the navigation
     * Currently always returns true to show this page in the navigation menu
     *
     * @return bool
     */
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function mount(): void
    {

        $this->buildTree();
    }

    protected function buildTree(): void
    {
        $nodes = Node::with(['parents', 'children'])->get();

        $this->nodes = $nodes->map(function ($node) {
            $baseConfig = config("infrastructure.nodes.types.{$node->type}");
            $color = config("infrastructure.nodes.statuses.{$node->status}");

            return array_merge($baseConfig, [
                'id' => $node->id,
                'label' => $node->name,
                'group' => $node->type,
                'font' => [
                    'color' => '#000000',
                    'size' => 14
                ],
                'color' => [
                    'background' => $color,
                    'border' => $color
                ],
                'title' => "Status: " . ucfirst($node->status)
            ]);
        });

        $this->edges = collect();
        $nodes->each(function ($node) {
            $node->children->each(function ($child) use ($node) {
                $this->edges->push([
                    'from' => $node->id,
                    'to' => $child->id,
                    'arrows' => 'to',
                    'width' => 2,
                    'color' => config("infrastructure.nodes.statuses.{$node->status}")
                ]);
            });
        });
    }
}
