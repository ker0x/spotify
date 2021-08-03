<?php

declare(strict_types=1);

namespace Kerox\Spotify\Helper;

trait UtilityTrait
{
    /**
     * Enhanced version of array_filter which allow to filter recursively.
     *
     * @param callable|array $callback
     */
    public function arrayFilter(array $array, array $callback = ['self', 'filter']): array
    {
        foreach ($array as $k => $v) {
            if (\is_array($v)) {
                $array[$k] = $this->arrayFilter($v, $callback);
            }
        }

        return array_filter($array, $callback);
    }

    /**
     * Callback function for filtering.
     *
     * @param mixed $var array to filter
     */
    protected static function filter($var): bool
    {
        return 0 === $var || 0.0 === $var || '0' === $var || !empty($var);
    }
}
