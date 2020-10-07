<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AudioAnalysisResponse;
use Kerox\Spotify\Response\AudioFeaturesResponse;

class Audio extends AbstractApi
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function analysis(string $id): AudioAnalysisResponse
    {
        $uri = $this->createUri(sprintf('audio-analysis/%s', $id));

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new AudioAnalysisResponse($response);
    }

    /**
     * @param string|array $ids
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function features($ids): AudioFeaturesResponse
    {
        if (\is_array($ids)) {
            $uri = $this->createUri('audio-features', (new QueryFactory())->setIds($ids));
        } else {
            $uri = $this->createUri(sprintf('audio-features/%s', $ids));
        }

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new AudioFeaturesResponse($response);
    }
}
