<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Tatum extends AbstractAudioAnalysis
{
    /**
     * @param array $tatum
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Tatum
     */
    public static function create(array $tatum): self
    {
        return new self($tatum['start'], $tatum['duration'], $tatum['confidence']);
    }
}
