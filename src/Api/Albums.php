<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\PagingResponse;

class Albums extends AbstractApi
{
    public const BASE_URI = 'albums';

    public function get(string $id, array $queryParameters = []): AlbumResponse
    {
        return new AlbumResponse($this->sendGetRequest(sprintf('%s/%s', self::BASE_URI, $id), $queryParameters));
    }

    public function many(array $queryParameters = []): AlbumsResponse
    {
        return new AlbumsResponse($this->sendGetRequest(self::BASE_URI, $queryParameters));
    }

    public function tracks(string $id, iterable $queryParameters = []): PagingResponse
    {
        return new PagingResponse($this->sendGetRequest(sprintf('%s/%s/tracks', self::BASE_URI, $id), $queryParameters));
    }
}
