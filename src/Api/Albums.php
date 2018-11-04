<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Psr\Http\Message\ResponseInterface;

class Albums extends AbstractApi
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
        $uri = $this->buildUri(sprintf('albums/%s', $id), [
            self::PARAMETER_MARKET => $market,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumResponse($response);
    }

    /**
     * @param string      $id
     * @param string|null $market
     * @param int         $limit
     * @param int         $offset
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function tracks(string $id, string $market = null, int $limit = 20, int $offset = 0): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('albums/%s/tracks', $id), [
            self::PARAMETER_MARKET => $market,
            self::PARAMETER_LIMIT => $limit,
            self::PARAMETER_OFFSET => $offset,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
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
        $this->isValidArray($ids, 20);

        $uri = $this->buildUri('albums', [
            self::PARAMETER_IDS => $ids,
            self::PARAMETER_MARKET => $market,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumsResponse($response);
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
        $uri = $this->buildUri('me/albums', [
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

        $uri = $this->buildUri('me/albums', [self::PARAMETER_IDS => $ids]);

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

        $uri = $this->buildUri('me/albums', [self::PARAMETER_IDS => $ids]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
