<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static POST()
 * @method static static PROJECT()
 * @method static static NEWS()
 */
final class NotificationType extends Enum
{
    const POST = 1; // Các thông báo về bài đăng
    const PROJECT = 2; // Các thông báo về dự án
    const NEWS = 3; // Các thông báo về tin tức
}
