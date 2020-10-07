<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\AudioAnalysis;

class AudioAnalysisResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis
     */
    protected $audioAnalysis;

    public function getAudioAnalysis(): AudioAnalysis
    {
        return $this->audioAnalysis;
    }

    protected function parseResponse(array $content): void
    {
        $this->audioAnalysis = AudioAnalysis::build($content);
    }
}
