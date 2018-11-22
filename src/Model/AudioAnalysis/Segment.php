<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Segment extends AbstractAudioAnalysis
{
    /**
     * @var float
     */
    protected $loudnessStart;

    /**
     * @var float
     */
    protected $loudnessMaxTime;

    /**
     * @var float
     */
    protected $loudnessMax;

    /**
     * @var float
     */
    protected $loudnessEnd;

    /**
     * @var float[]
     */
    protected $pitches;

    /**
     * @var float[]
     */
    protected $timbre;

    /**
     * Segment constructor.
     *
     * @param float   $start
     * @param float   $duration
     * @param float   $confidence
     * @param float   $loudnessStart
     * @param float   $loudnessMaxTime
     * @param float   $loudnessMax
     * @param float   $loudnessEnd
     * @param float[] $pitches
     * @param float[] $timbre
     */
    public function __construct(
        float $start,
        float $duration,
        float $confidence,
        float $loudnessStart,
        float $loudnessMaxTime,
        float $loudnessMax,
        float $loudnessEnd,
        array $pitches,
        array $timbre
    ) {
        parent::__construct($start, $duration, $confidence);

        $this->loudnessStart = $loudnessStart;
        $this->loudnessMaxTime = $loudnessMaxTime;
        $this->loudnessMax = $loudnessMax;
        $this->loudnessEnd = $loudnessEnd;
        $this->pitches = $pitches;
        $this->timbre = $timbre;
    }

    /**
     * @param array $segment
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Segment
     */
    public static function build(array $segment): self
    {
        return new self(
            $segment['start'],
            $segment['duration'],
            $segment['confidence'],
            $segment['loudness_start'],
            $segment['loudness_max_time'],
            $segment['loudness_max'],
            $segment['loudness_end'],
            $segment['pitches'],
            $segment['timbre']
        );
    }

    /**
     * @return float
     */
    public function getLoudnessStart(): float
    {
        return $this->loudnessStart;
    }

    /**
     * @return float
     */
    public function getLoudnessMaxTime(): float
    {
        return $this->loudnessMaxTime;
    }

    /**
     * @return float
     */
    public function getLoudnessMax(): float
    {
        return $this->loudnessMax;
    }

    /**
     * @return float
     */
    public function getLoudnessEnd(): float
    {
        return $this->loudnessEnd;
    }

    /**
     * @return float[]
     */
    public function getPitches(): array
    {
        return $this->pitches;
    }

    /**
     * @return float[]
     */
    public function getTimbre(): array
    {
        return $this->timbre;
    }
}
