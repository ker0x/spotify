<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\AudioFeatures;

class AudioFeaturesResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\AudioFeatures|\Kerox\Spotify\Model\AudioFeatures[]
     */
    protected $audioFeatures;

    /**
     * @return \Kerox\Spotify\Model\AudioFeatures|\Kerox\Spotify\Model\AudioFeatures[]
     */
    public function getAudioFeatures()
    {
        return $this->audioFeatures;
    }

    protected function parseResponse(array $content): void
    {
        if (isset($content['audio_features'])) {
            $audioFeatures = [];
            foreach ($content['audio_features'] as $audioFeature) {
                $audioFeatures[] = AudioFeatures::build($audioFeature);
            }

            $this->audioFeatures = $audioFeatures;
        } else {
            $this->audioFeatures = AudioFeatures::build($content);
        }
    }
}
