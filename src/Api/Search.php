<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\SearchResponse;

class Search extends AbstractApi implements TypeInterface
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function __invoke(array $queryParameters = []): SearchResponse
    {
        $uri = $this->createUri('search', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new SearchResponse($response);
    }
}
