<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Tatum extends AbstractAudioAnalysis
{
    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Tatum
     */
    public static function build(array $tatum): self
    {
        return new self($tatum['start'], $tatum['duration'], $tatum['confidence']);
    }
}
