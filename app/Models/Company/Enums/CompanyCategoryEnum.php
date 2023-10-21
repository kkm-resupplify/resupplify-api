<?php

namespace App\Models\Company\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self FOOD_PRODUCTS()
 * @method static self PERSONAL_CARE_PRODUCTS()
 * @method static self CLEANING_PRODUCTS()
 * @method static self BEVERAGES()
 * @method static self TOBACCO_PRODUCTS()
 * @method static self PHARMACEUTICALS()
 * @method static self CONFECTIONERY()
 * @method static self HOUSEHOLD_GOODS()
 * @method static self BABY_CARE_PRODUCTS()
 * @method static self PET_CARE_PRODUCTS()
 * @method static self PAPER_PRODUCTS()
 * @method static self SNACK_FOODS()
 * @method static self BAKED_GOODS()
 * @method static self PERSONAL_HYGIENE_PRODUCTS()
 * @method static self HOME_CARE_PRODUCTS()
 */
final class CompanyCategoryEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'FOOD_PRODUCTS' => 1,
            'PERSONAL_CARE_PRODUCTS' => 2,
            'CLEANING_PRODUCTS' => 3,
            'BEVERAGES' => 4,
            'TOBACCO_PRODUCTS' => 5,
            'PHARMACEUTICALS' => 6,
            'CONFECTIONERY' => 7,
            'HOUSEHOLD_GOODS' => 8,
            'BABY_CARE_PRODUCTS' => 9,
            'PET_CARE_PRODUCTS' => 10,
            'PAPER_PRODUCTS' => 11,
            'SNACK_FOODS' => 12,
            'BAKED_GOODS' => 13,
            'PERSONAL_HYGIENE_PRODUCTS' => 14,
            'HOME_CARE_PRODUCTS' => 15,
        ];
    }
}
