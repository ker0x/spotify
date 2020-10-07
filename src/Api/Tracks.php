<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\TrackResponse;
use Kerox\Spotify\Response\TracksResponse;

class Tracks extends AbstractApi
{
    public const BASE_URI = 'tracks';

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $id, iterable $queryParameters = []): TrackResponse
    {
        $uri = $this->createUri(sprintf('tracks/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TrackResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function multiple(iterable $queryParameters = []): TracksResponse
    {
        $uri = $this->createUri('tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }
}
