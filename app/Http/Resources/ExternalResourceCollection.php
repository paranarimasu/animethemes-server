<?php

namespace App\Http\Resources;

use App\JsonApi\Filter\ExternalResource\ExternalResourceSiteFilter;
use App\JsonApi\Traits\PerformsResourceCollectionQuery;

class ExternalResourceCollection extends BaseCollection
{
    use PerformsResourceCollectionQuery;

    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'resources';

    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($resource) {
            return ExternalResourceResource::make($resource, $this->parser);
        })->all();
    }

    /**
     * The include paths a client is allowed to request.
     *
     * @var array
     */
    public static function allowedIncludePaths()
    {
        return [
            'anime',
            'artists',
        ];
    }

    /**
     * The sort field names a client is allowed to request.
     *
     * @var array
     */
    public static function allowedSortFields()
    {
        return [
            'resource_id',
            'created_at',
            'updated_at',
            'site',
            'link',
            'external_id',
        ];
    }

    /**
     * The filters that can be applied by the client for this resource.
     *
     * @var array
     */
    public static function filters()
    {
        return [
            ExternalResourceSiteFilter::class,
        ];
    }
}
