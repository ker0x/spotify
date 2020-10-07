<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Factory\QueryFactoryInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\FollowingResponse;
use Psr\Http\Message\ResponseInterface;

class Follow extends AbstractApi implements TypeInterface
{
    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function following(iterable $queryParameters = []): FollowingResponse
    {
        $uri = $this->createUri('me/following/contains', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new FollowingResponse($response, $queryParameters[QueryFactoryInterface::PARAMETER_IDS]);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function add(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/following', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function delete(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/following', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
