<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static APPLIED()
 * @method static static ACCEPTED()
 * @method static static DELETED()
 */
final class BrokerAdviceRequestStatus extends Enum
{
    const APPLIED = 0;
    const ACCEPTED = 1;
    const DELETED = 2;
}
