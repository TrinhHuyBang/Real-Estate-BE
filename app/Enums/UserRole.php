<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static USER()
 * @method static static ENTERPRISE()
 * @method static static BROKER()
 */
final class UserRole extends Enum
{
    const USER = 1;
    const ENTERPRISE = 2;
    const BROKER = 3;
}
