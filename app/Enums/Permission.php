<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Permission extends Enum
{
    const VIEW_ANY_POST = 1;
    const VIEW_POST = 2;
    const UPDATE_POST = 3;
    const DELETE_POST = 4;

    const VIEW_ANY_PROJECT = 5;
    const VIEW_PROJECT = 6;
    const UPDATE_PROJECT = 7;
    const DELETE_PROJECT = 8;

    const VIEW_ANY_NEWS = 9;
    const VIEW_NEWS = 10;
    const CREATE_NEWS = 11;
    const UPDATE_NEWS = 12;
    const DELETE_NEWS = 13;

    const VIEW_ANY_USER_ACCOUNT = 14;
    const VIEW_USER_ACCOUNT = 15;
    const UPDATE_USER_ACCOUNT = 16;
}
