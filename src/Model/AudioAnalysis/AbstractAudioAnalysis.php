<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

use Kerox\Spotify\Interfaces\ModelInterface;

abstract class AbstractAudioAnalysis implements ModelInterface
{
    /**
     * @var float
     */
    protected $start;

    /**
     * @var float
     */
    protected $duration;

    /**
     * @var float
     */
    protected $confidence;

    /**
     * AbstractAudioAnalysis constructor.
     */
    public function __construct(float $start, float $duration, float $confidence)
    {
        $this->start = $start;
        $this->duration = $duration;
        $this->confidence = $confidence;
    }

    public function getStart(): float
    {
        return $this->start;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function getConfidence(): float
    {
        return $this->confidence;
    }
}
