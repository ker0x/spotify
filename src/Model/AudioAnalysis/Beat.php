<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Beat extends AbstractAudioAnalysis
{
    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Beat
     */
    public static function build(array $beat): self
    {
        return new self($beat['start'], $beat['duration'], $beat['confidence']);
    }
}
