<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Factory\QueryFactoryInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\UriFactory;

class AbstractApi
{
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
     * @param string   $uri
     * @param iterable $queryParameters
     *
     * @return \Psr\Http\Message\UriInterface
     */
    protected function createUri(string $uri, iterable $queryParameters = []): UriInterface
    {
        $queryFactory = new QueryFactory();
        if ($queryParameters instanceof QueryFactoryInterface) {
            $queryFactory = $queryParameters;
        }

        if (is_array($queryParameters)) {
            $queryFactory->setFromArray($queryParameters);
        }

        return (new UriFactory)->createUri(sprintf(
            '%s/%s?%s',
            $this->baseUri,
            $uri,
            urlencode($queryFactory->createQuery())
        ));
    }
}
