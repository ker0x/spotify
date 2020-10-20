<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Bar extends AbstractAudioAnalysis
{
    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Bar
     */
    public static function build(array $bar): self
    {
        return new self($bar['start'], $bar['duration'], $bar['confidence']);
    }
}
