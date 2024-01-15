<?php

namespace App\Traits;

trait EnumValueTrait
{
    /**
     * Validates if the given string value exists in the enum cases.
     *
     * @param string $value The string value to be validated against the enum cases.
     * @throws \ValueError When the given value is not a valid case for the enum class.
     * @return string The validated string value that corresponds to an enum case.
     */
    public static function fromValue(string $value): string
    {
        foreach (self::cases() as $case) {
            if ($value === $case->value) {
                return $case->value;
            }
        }

        throw new \ValueError("$value is not a valid value for " . static::class);
    }
}
