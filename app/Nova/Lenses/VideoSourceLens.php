<?php

namespace App\Nova\Lenses;

use App\Models\Video;
use App\Nova\Filters\RecentlyCreatedFilter;
use App\Nova\Filters\RecentlyUpdatedFilter;
use App\Nova\Filters\VideoTypeFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;

class VideoSourceLens extends Lens
{

    /**
     * Get the displayable name of the lens.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.video_unknown_source_lens');
    }

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return Video::whereNull('source');
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('nova.id'), 'video_id')
                ->sortable(),

            Text::make(__('nova.filename'), 'filename')
                ->sortable(),

            Number::make(__('nova.resolution'), 'resolution')
                ->sortable(),

            Boolean::make(__('nova.nc'), 'nc')
                ->sortable(),

            Boolean::make(__('nova.subbed'), 'subbed')
                ->sortable(),

            Boolean::make(__('nova.lyrics'), 'lyrics')
                ->sortable(),

            Boolean::make(__('nova.uncen'), 'uncen')
                ->sortable(),

            //TODO: Exception when Overlap field is included
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new VideoTypeFilter,
            new RecentlyCreatedFilter,
            new RecentlyUpdatedFilter
        ];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'video-source-lens';
    }
}