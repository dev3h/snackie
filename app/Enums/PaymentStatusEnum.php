<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentStatusEnum extends Enum
{
    public const DANG_CHO_XU_LY = 0;

    public static function getArrayView()
    {
        return [
            'Đang chờ xử lý' => self::DANG_CHO_XU_LY,
        ];
    }

    public static function getKeyByValue($value)
    {
        return array_search($value, self::getArrayView(), true);
    }
}
