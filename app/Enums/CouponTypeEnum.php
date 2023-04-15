<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CouponTypeEnum extends Enum
{
    public const GIAM_THEO_PHAN_TRAM = 0;
    public const GIAM_THEO_TIEN = 1;

    public static function getArrayView()
    {
        return [
            'Giảm theo phần trăm' => self::GIAM_THEO_PHAN_TRAM,
            'Giảm theo tiền' => self::GIAM_THEO_TIEN,
        ];
    }

    public static function getKeyByValue($value)
    {
        return array_search($value, self::getArrayView(), true);
    }
}
