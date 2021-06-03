<?php

declare(strict_types=1);

namespace App\Nova\Filters;

use App\Enums\Filter\ComparisonOperator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;

/**
 * Class CreatedEndDateFilter.
 */
class CreatedEndDateFilter extends DateFilter
{
    /**
     * Get the displayable name of the filter.
     *
     * @return array|string|null
     */
    public function name(): array | string | null
    {
        return __('nova.created_at_end');
    }

    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value): Builder
    {
        $value = Carbon::parse($value);

        return $query->where(Model::CREATED_AT, ComparisonOperator::LTE, $value);
    }
}