<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static HANDED_OVER()
 * @method static static ON_SALE()
 * @method static static PREPARING_SALE()
 * @method static static UPDATING()
 * @method static static ALL()
 */
final class ProjectStatus extends Enum
{
    const ALL = 0;
    const HANDED_OVER = 3;
    const ON_SALE = 2;
    const PREPARING_SALE = 1;
    const UPDATING = 4;
}
