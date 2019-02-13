<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\TrackResponse;
use Kerox\Spotify\Response\TracksResponse;
use Psr\Http\Message\ResponseInterface;

class Tracks extends AbstractApi
{
    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\TrackResponse
     */
    public function getTrack(string $id, array $queryParameters = []): TrackResponse
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
     *
     * @return \Kerox\Spotify\Response\TracksResponse
     */
    public function getTracks(array $queryParameters = []): TracksResponse
    {
        $uri = $this->createUri('tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }
}
