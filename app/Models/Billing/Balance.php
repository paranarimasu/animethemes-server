<?php

declare(strict_types=1);

namespace App\Models\Billing;

use App\Enums\Billing\Frequency;
use App\Enums\Billing\Service;
use App\Enums\Filter\AllowedDateFormat;
use App\Events\Billing\Balance\BalanceCreated;
use App\Events\Billing\Balance\BalanceDeleted;
use App\Events\Billing\Balance\BalanceRestored;
use App\Events\Billing\Balance\BalanceUpdated;
use App\Models\BaseModel;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Support\Str;

/**
 * Class Balance.
 */
class Balance extends BaseModel
{
    use CastsEnums;

    /**
     * @var array
     */
    protected $fillable = ['date', 'service', 'frequency', 'usage', 'balance'];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => BalanceCreated::class,
        'deleted' => BalanceDeleted::class,
        'restored' => BalanceRestored::class,
        'updated' => BalanceUpdated::class,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'balance';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'balance_id';

    /**
     * @var array
     */
    protected $enumCasts = [
        'service' => Service::class,
        'frequency' => Frequency::class,
    ];

    /**
     * @var array
     */
    protected $casts = [
        'service' => 'int',
        'frequency' => 'int',
        'date' => 'date:Y-m-d',
    ];

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return Str::of($this->service->description)
            ->append(' ')
            ->append($this->date->format(AllowedDateFormat::WITH_MONTH))
            ->__toString();
    }
}