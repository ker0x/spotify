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

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis
     */
    public function getAudioAnalysis(): AudioAnalysis
    {
        return $this->audioAnalysis;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->audioAnalysis = AudioAnalysis::build($content);
    }
}
