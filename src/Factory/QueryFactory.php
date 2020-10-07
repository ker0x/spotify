<?php

declare(strict_types=1);

namespace Kerox\Spotify\Factory;

class QueryFactory implements QueryFactoryInterface, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setFromArray(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setAfter(string $after): self
    {
        $this->parameters[self::PARAMETER_AFTER] = $after;

        return $this;
    }

    /**
     * @param string|array $ids
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setIds($ids): self
    {
        if (\is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $this->parameters[self::PARAMETER_IDS] = $ids;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setMarket(string $market = 'US'): self
    {
        $this->parameters[self::PARAMETER_MARKET] = $market;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setLocale(string $locale = 'en_US'): self
    {
        $this->parameters[self::PARAMETER_LOCALE] = $locale;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setCountry(string $country = 'US'): self
    {
        $this->parameters[self::PARAMETER_COUNTRY] = $country;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setTimestamp(\DateTime $timestamp): self
    {
        $this->parameters[self::PARAMETER_TIMESTAMP] = $timestamp->format(\DateTime::ATOM);

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setTimeRange(string $timeRange = self::TIME_RANGE_MEDIUM): self
    {
        $this->parameters[self::PARAMETER_TIME_RANGE] = $timeRange;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setLimit(int $limit = 20): self
    {
        $this->parameters[self::PARAMETER_LIMIT] = $limit;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setOffset(int $offset = 0): self
    {
        $this->parameters[self::PARAMETER_OFFSET] = $offset;

        return $this;
    }

    /**
     * @param string ...$types
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setType(string ...$types): self
    {
        $this->parameters[self::PARAMETER_TYPE] = implode(',', $types);

        return $this;
    }

    /**
     * @param string ...$includeGroups
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setIncludeGroups(string ...$includeGroups): self
    {
        $this->parameters[self::PARAMETER_INCLUDE_GROUPS] = implode(',', $includeGroups);

        return $this;
    }

    public function createQuery(): string
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

    /**
     * Retrieve an external iterator.
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this);
    }

    public function __toString(): string
    {
        return $this->createQuery();
    }
}
