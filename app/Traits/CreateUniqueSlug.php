<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CreateUniqueSlug
{
    /**
     * Generates a unique slug based on the given strings.
     *
     * @param mixed ...$strings The strings to be used for generating the slug.
     * @throws Some_Exception_Class If an error occurs while generating the slug.
     * @return string The generated unique slug.
     */
    protected static function createUniqueSlug(...$strings): string
    {
        $baseSlug = Str::slug(implode(' ', $strings));
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
