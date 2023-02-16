<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentMethodEnum extends Enum
{
    public const THE_TIN_DUNG = 0;
    public const THANH_TOAN_KHI_NHAN_HANG = 1;
    public const THE_GHI_NO = 2;

    public static function getArrayView() {
        return [
            'Thẻ tín dụng' => self::THE_TIN_DUNG,
            'Thanh toán khi nhận hàng' => self::THANH_TOAN_KHI_NHAN_HANG,
            'Thẻ ghi nợ' => self::THE_GHI_NO,
        ];
    }

    public static function getKeyByValue($value) {
        return array_search($value, self::getArrayView(), true);
    }
}
