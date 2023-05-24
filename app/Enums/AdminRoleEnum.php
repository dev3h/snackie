<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AdminRoleEnum extends Enum
{
    public const NHAN_VIEN = 0;
    public const QUAN_LY = 1;

    public static function getArrayView()
    {
        return [
            'Nhân viên' => self::NHAN_VIEN,
            'Quản lý' => self::QUAN_LY,
        ];
    }

    public static function getKeyByValue($value)
    {
        return array_search($value, self::getArrayView(), true);
    }
}
