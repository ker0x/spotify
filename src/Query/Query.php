<?php

namespace Kerox\Spotify\Query;

use ArrayIterator;
use DateTime;
use IteratorAggregate;
use Kerox\Spotify\Factory\QueryInterface;
use Traversable;

class Query implements QueryInterface, IteratorAggregate
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @param string|array $ids
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setIds(array $ids): self
    {
        $this->parameters[self::PARAMETER_IDS] = implode(',', $ids);

        return $this;
    }

    /**
     * @param string $market
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setMarket(string $market = 'US'): self
    {
        $this->parameters[self::PARAMETER_MARKET] = $market;

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setLocale(string $locale = 'en_US'): self
    {
        $this->parameters[self::PARAMETER_LOCALE] = $locale;

        return $this;
    }

    /**
     * @param string $country
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setCountry(string $country = 'US'): self
    {
        $this->parameters[self::PARAMETER_COUNTRY] = $country;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setTimestamp(DateTime $timestamp): self
    {
        $this->parameters[self::PARAMETER_TIMESTAMP] = $timestamp->format(DateTime::ATOM);

        return $this;
    }

    /**
     * @param string $timeRange
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setTimeRange(string $timeRange = self::TIME_RANGE_MEDIUM): self
    {
        $this->parameters[self::PARAMETER_TIME_RANGE] = $timeRange;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setLimit(int $limit = 20): self
    {
        $this->parameters[self::PARAMETER_LIMIT] = $limit;

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setOffset(int $offset = 0): self
    {
        $this->parameters[self::PARAMETER_OFFSET] = $offset;

        return $this;
    }

    /**
     * @param string ...$types
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setType(string ...$types): self
    {
        $this->parameters[self::PARAMETER_TYPE] = implode(',', $types);

        return $this;
    }

    /**
     * @param string ...$includeGroups
     *
     * @return \Kerox\Spotify\Query\Query
     */
    public function setIncludeGroups(string ...$includeGroups): self
    {
        $this->parameters[self::PARAMETER_INCLUDE_GROUPS] = implode(',', $includeGroups);

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Retrieve an external iterator
     *
     * @link  https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this);
    }
}
