<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Recommendations;

class RecommendationsResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Recommendations
     */
    protected $recommendations;

    public function getRecommendations(): Recommendations
    {
        return $this->recommendations;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->recommendations = Recommendations::create($content);
    }
}
