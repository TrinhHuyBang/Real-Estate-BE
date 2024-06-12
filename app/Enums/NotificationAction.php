<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static REJECT()
 * @method static static ACCEPT()
 * @method static static REPORT()
 */
final class NotificationAction extends Enum
{
    const REJECT = 0; // Từ chối yêu cầu đăng tin đăng của người dùng / dự án doanh nghiệp / ....
    const ACCEPT = 1; // Chấp nhận yêu cầu đăng tin ...
    const DELETE = 2; // Xoá bài đăng
    const REPORT = 3; // Bị báo cáo về bài đăng
}
