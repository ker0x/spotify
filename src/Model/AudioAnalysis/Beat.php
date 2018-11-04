<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Beat extends AbstractAudioAnalysis
{
    /**
     * @param array $beat
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Beat
     */
    public static function create(array $beat): self
    {
        return new self($beat['start'], $beat['duration'], $beat['confidence']);
    }
}
