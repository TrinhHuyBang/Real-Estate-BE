<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReportStatus extends Enum
{
    const PROCESSED = 1;
    const DELETED = 2;
    const WATING = 0;
}
