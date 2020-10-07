<?php

declare(strict_types=1);

namespace Kerox\Spotify\Query;

final class Query implements QueryInterface
{
    /**
     * @var array
     */
    private $parameters = [];

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function __toString(): string
    {
        $query = [];
        foreach ($this->parameters as $parameter => $value) {
            if (\is_array($value)) {
                $value = implode(',', $value);
            }

            $query[] = sprintf('%s=%s', $parameter, (string) $value);
        }

        return implode('&', $query);
    }
}
