<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatusEnum extends Enum
{
    public const DANG_CHO_XU_LY = 0;
    public const DA_XU_LY = 1;
    public const DANG_GIAO = 2;
    public const DA_GIAO = 3;
    public const DA_HUY = 4;

    public static function getArrayView()
    {
        return [
            'Đang chờ xử lý' => self::DANG_CHO_XU_LY,
            'Đã xử lý' => self::DA_XU_LY,
            'Đang giao' => self::DANG_GIAO,
            'Đã giao' => self::DA_GIAO,
            'Đã hủy' => self::DA_HUY,
        ];
    }

    public static function getKeyByValue($value)
    {
        return array_search($value, self::getArrayView(), true);
    }
}
