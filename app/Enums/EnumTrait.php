<?php

namespace App\Enums;

trait EnumTrait
{
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $label = method_exists($case, 'label')
                ? $case->label()
                : str($case->value)->replace('_', ' ')->title()->value();

            $options[$case->value] = $label;
        }

        return $options;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
