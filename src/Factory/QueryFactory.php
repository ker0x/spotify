<?php

namespace Kerox\Spotify\Factory;

use DateTime;
use Traversable;

class QueryFactory implements QueryFactoryInterface, Traversable
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @param array $parameters
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setFromArray(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param string|array $ids
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setIds($ids): self
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $this->parameters[self::PARAMETER_IDS] = $ids;

        return $this;
    }

    /**
     * @param string $market
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setMarket(string $market = 'US'): self
    {
        $this->parameters[self::PARAMETER_MARKET] = $market;

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setLocale(string $locale = 'en_US'): self
    {
        $this->parameters[self::PARAMETER_LOCALE] = $locale;

        return $this;
    }

    /**
     * @param string $country
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setCountry(string $country = 'US'): self
    {
        $this->parameters[self::PARAMETER_COUNTRY] = $country;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setTimestamp(DateTime $timestamp): self
    {
        $this->parameters[self::PARAMETER_TIMESTAMP] = $timestamp->format(DateTime::ATOM);

        return $this;
    }

    /**
     * @param string $timeRange
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setTimeRange(string $timeRange = self::TIME_RANGE_MEDIUM): self
    {
        $this->parameters[self::PARAMETER_TIME_RANGE] = $timeRange;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return \Kerox\Spotify\Factory\QueryFactory
     */
    public function setLimit(int $limit = 20): self
    {
        $this->parameters[self::PARAMETER_LIMIT] = $limit;

        return $this;
    }

    /**
     * @param int $offset
     *
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

    /**
     * @return string
     */
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->createQuery();
    }
}
