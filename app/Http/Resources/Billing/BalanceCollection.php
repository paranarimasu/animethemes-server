<?php

declare(strict_types=1);

namespace App\Http\Resources\Billing;

use App\Concerns\JsonApi\PerformsResourceCollectionQuery;
use App\Http\Resources\BaseCollection;
use App\JsonApi\Filter\Base\CreatedAtFilter;
use App\JsonApi\Filter\Base\DeletedAtFilter;
use App\JsonApi\Filter\Base\TrashedFilter;
use App\JsonApi\Filter\Base\UpdatedAtFilter;
use App\JsonApi\Filter\Billing\Balance\BalanceDateFilter;
use App\JsonApi\Filter\Billing\Balance\BalanceFrequencyFilter;
use App\JsonApi\Filter\Billing\Balance\BalanceServiceFilter;
use App\Models\Billing\Balance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class BalanceCollection.
 */
class BalanceCollection extends BaseCollection
{
    use PerformsResourceCollectionQuery;

    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'balances';

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->collection->map(function (BalanceResource $resource) {
            return $resource->parser($this->parser);
        })->all();
    }

    /**
     * Resolve the model query builder from collection class name.
     * We are assuming a convention of "{Model}Collection".
     *
     * @return Builder
     */
    protected static function queryBuilder(): Builder
    {
        return Balance::query();
    }

    /**
     * The sort field names a client is allowed to request.
     *
     * @return array
     */
    public static function allowedSortFields(): array
    {
        return [
            'balance_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'date',
            'service',
            'frequency',
            'usage',
            'month_to_date_balance',
        ];
    }

    /**
     * The filters that can be applied by the client for this resource.
     *
     * @return array
     */
    public static function filters(): array
    {
        return [
            BalanceDateFilter::class,
            BalanceFrequencyFilter::class,
            BalanceServiceFilter::class,
            CreatedAtFilter::class,
            UpdatedAtFilter::class,
            DeletedAtFilter::class,
            TrashedFilter::class,
        ];
    }
}