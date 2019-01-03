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
     *
     * @param float $start
     * @param float $duration
     * @param float $confidence
     */
    public function __construct(float $start, float $duration, float $confidence)
    {
        $this->start = $start;
        $this->duration = $duration;
        $this->confidence = $confidence;
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }
}
