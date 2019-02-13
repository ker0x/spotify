<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\QueryFactoryInterface;
use Kerox\Spotify\Query\Query;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AudioAnalysisResponse;
use Kerox\Spotify\Response\AudioFeaturesResponse;

class Audio extends AbstractApi
{
    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\AudioAnalysisResponse
     */
    public function getAnalysis(string $id): AudioAnalysisResponse
    {
        $uri = $this->createUri(sprintf('audio-analysis/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AudioAnalysisResponse($response);
    }

    /**
     * @param string|array $ids
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\AudioFeaturesResponse
     */
    public function getFeatures($ids): AudioFeaturesResponse
    {
        if (\is_array($ids)) {
            $uri = $this->createUri('audio-features', (new Query)->setIds($ids));
        } else {
            $uri = $this->createUri(sprintf('audio-features/%s', $ids));
        }

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AudioFeaturesResponse($response);
    }
}
