<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\SearchResponse;

class Search extends AbstractApi implements TypeInterface
{
    public function __invoke(iterable $queryParameters = []): SearchResponse
    {
        $uri = $this->createUri('search', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new SearchResponse($response);
    }
}
