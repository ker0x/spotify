<?php

declare(strict_types=1);

namespace Kerox\Spotify\Helper;

use Kerox\Spotify\Exception\InvalidArrayException;
use Kerox\Spotify\Exception\InvalidLimitException;
use Kerox\Spotify\Exception\InvalidQueryParameterException;

trait ValidatorTrait
{
    /**
     * @param array $array
     * @param int   $maxSize
     * @param int   $minSize
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     */
    protected function isValidArray(array $array, int $maxSize, ?int $minSize = null): void
    {
        $countArray = \count($array);
        if ($minSize !== null && $countArray < $minSize) {
            throw new InvalidArrayException(sprintf('The minimum number of items for this array is %d.', $minSize));
        }
        if ($countArray > $maxSize) {
            throw new InvalidArrayException(sprintf('The maximum number of items for this array is %d.', $maxSize));
        }
    }

    /**
     * @param int $limit
     * @param int $max
     * @param int $min
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     */
    protected function isValidLimit(int $limit, int $max = 50, int $min = 1): void
    {
        if ($limit < $min || $limit > $max) {
            throw new InvalidLimitException(sprintf('Limit must be between %d and %d.', $min, $max));
        }
    }

    /**
     * @param array $queryParameters
     * @param array $allowedQueryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     */
    protected function isValidQueryParameters(array $queryParameters, array $allowedQueryParameters): void
    {
        foreach ($queryParameters as $parameter => $value) {
            if (!\in_array($parameter, $allowedQueryParameters, true)) {
                throw new InvalidQueryParameterException(sprintf(
                    'Query parameters must be either "%s".',
                    implode(', ', $allowedQueryParameters)
                ));
            }
        }
    }
}
