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
     * @param string      $id
     * @param string|null $market
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $id, string $market = null): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('tracks/%s', $id), [
            self::PARAMETER_MARKET => $market,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TrackResponse($response);
    }

    /**
     * @param array       $ids
     * @param string|null $market
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function several(array $ids, string $market = null): ResponseInterface
    {
        $this->isValidArray($ids, 50);

        $uri = $this->buildUri('tracks', [
            self::PARAMETER_IDS => $ids,
            self::PARAMETER_MARKET => $market,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }

    /**
     * @param int         $limit
     * @param int         $offset
     * @param string|null $market
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function saved(int $limit = 20, int $offset = 0, string $market = null): ResponseInterface
    {
        $uri = $this->buildUri('me/tracks', [
            self::PARAMETER_LIMIT => $limit,
            self::PARAMETER_OFFSET => $offset,
            self::PARAMETER_MARKET => $market,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $ids
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add(array $ids): ResponseInterface
    {
        $this->isValidArray($ids, 50);

        $uri = $this->buildUri('me/tracks', [self::PARAMETER_IDS => $ids]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $ids
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function remove(array $ids): ResponseInterface
    {
        $this->isValidArray($ids, 50);

        $uri = $this->buildUri('me/tracks', [self::PARAMETER_IDS => $ids]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
