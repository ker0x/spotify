<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\ArtistResponse;
use Psr\Http\Message\ResponseInterface;

class Artists extends AbstractApi
{
    /**
     * @param string $id
     *
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $id): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('artists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function albums(string $id, array $queryParameters = []): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('artists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }
}
