<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\FollowInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\FollowingResponse;
use Psr\Http\Message\ResponseInterface;

class Follow extends AbstractApi implements FollowInterface
{
    /**
     * @param array  $ids
     * @param string $type
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function following(array $ids, string $type = self::TYPE_ARTIST): ResponseInterface
    {
        $this->isValidArray($ids, 50);

        $uri = $this->buildUri('me/following/contains', [
            self::PARAMETER_IDS => $ids,
            self::PARAMETER_TYPE => $type,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new FollowingResponse($response, $ids);
    }

    public function add(): ResponseInterface
    {

    }

    public function delete(): ResponseInterface
    {

    }

    public function get(): ResponseInterface
    {

    }
}
