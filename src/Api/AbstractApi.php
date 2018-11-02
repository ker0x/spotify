<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Kerox\Spotify\Helper\UtilityTrait;
use Kerox\Spotify\Helper\ValidatorTrait;
use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\UriFactory;

class AbstractApi implements QueryParametersInterface
{
    use UtilityTrait;
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $oauthToken;

    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * AbstractApi constructor.
     *
     * @param string                           $oauthToken
     * @param \Psr\Http\Client\ClientInterface $client
     * @param string                           $baseUri
     */
    public function __construct(string $oauthToken, ClientInterface $client, string $baseUri)
    {
        $this->oauthToken = $oauthToken;
        $this->client = $client;
        $this->baseUri = $baseUri;
    }

    /**
     * @param string $uri
     * @param array  $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     *
     * @return \Psr\Http\Message\UriInterface
     */
    protected function buildUri(string $uri, array $queryParameters = []): UriInterface
    {
        $queryParameters = $this->arrayFilter($queryParameters);

        $query = [];
        foreach ($queryParameters as $parameter => $value) {
            if ($parameter === self::PARAMETER_LIMIT) {
                $this->isValidLimit($value);
            }

            if ($parameter === self::PARAMETER_IDS) {
                $value = implode(',', $value);
            }

            $query[] = sprintf('%s=%s', $parameter, (string) $value);
        }

        $factory = new UriFactory();

        return $factory->createUri(sprintf('%s/%s?%s', $this->baseUri, $uri, implode('&', $query)));
    }
}
