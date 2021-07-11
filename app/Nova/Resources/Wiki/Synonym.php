<?php

declare(strict_types=1);

namespace App\Nova\Resources\Wiki;

use App\Nova\Resources\Resource;
use Devpartners\AuditableLog\AuditableLog;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

/**
 * Class Synonym.
 */
class Synonym extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Wiki\Synonym::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'text';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Get the displayable label of the resource.
     *
     * @return array|string|null
     */
    public static function label(): array | string | null
    {
        return __('nova.synonyms');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return array|string|null
     */
    public static function singularLabel(): array | string | null
    {
        return __('nova.synonym');
    }

    /**
     * The columns that should be searched.
     *
     * @var string[]
     */
    public static $search = [
        'text',
    ];

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            BelongsTo::make(__('nova.anime'), 'Anime', Anime::class)
                ->readonly(),

            ID::make(__('nova.id'), 'synonym_id')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            new Panel(__('nova.timestamps'), $this->timestamps()),

            Text::make(__('nova.text'), 'text')
                ->sortable()
                ->rules('required', 'max:192')
                ->help(__('nova.synonym_text_help')),

            AuditableLog::make(),
        ];
    }
}