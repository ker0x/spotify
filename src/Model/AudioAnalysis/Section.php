<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Section extends AbstractAudioAnalysis
{
    /**
     * @var float
     */
    protected $loudness;

    /**
     * @var float
     */
    protected $tempo;

    /**
     * @var float
     */
    protected $tempoConfidence;

    /**
     * @var float
     */
    protected $key;

    /**
     * @var float
     */
    protected $keyConfidence;

    /**
     * @var float
     */
    protected $mode;

    /**
     * @var float
     */
    protected $modeConfidence;

    /**
     * @var float
     */
    protected $timeSignature;

    /**
     * @var float
     */
    protected $timeSignatureConfidence;

    /**
     * Section constructor.
     */
    public function __construct(
        float $start,
        float $duration,
        float $confidence,
        float $loudness,
        float $tempo,
        float $tempoConfidence,
        float $key,
        float $keyConfidence,
        float $mode,
        float $modeConfidence,
        float $timeSignature,
        float $timeSignatureConfidence
    ) {
        parent::__construct($start, $duration, $confidence);

        $this->loudness = $loudness;
        $this->tempo = $tempo;
        $this->tempoConfidence = $tempoConfidence;
        $this->key = $key;
        $this->keyConfidence = $keyConfidence;
        $this->mode = $mode;
        $this->modeConfidence = $modeConfidence;
        $this->timeSignature = $timeSignature;
        $this->timeSignatureConfidence = $timeSignatureConfidence;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Section
     */
    public static function build(array $section): self
    {
        return new self(
            $section['start'],
            $section['duration'],
            $section['confidence'],
            $section['loudness'],
            $section['tempo'],
            $section['tempo_confidence'],
            $section['key'],
            $section['key_confidence'],
            $section['mode'],
            $section['mode_confidence'],
            $section['time_signature'],
            $section['time_signature_confidence']
        );
    }

    public function getLoudness(): float
    {
        return $this->loudness;
    }

    public function getTempo(): float
    {
        return $this->tempo;
    }

    public function getTempoConfidence(): float
    {
        return $this->tempoConfidence;
    }

    public function getKey(): float
    {
        return $this->key;
    }

    public function getKeyConfidence(): float
    {
        return $this->keyConfidence;
    }

    public function getMode(): float
    {
        return $this->mode;
    }

    public function getModeConfidence(): float
    {
        return $this->modeConfidence;
    }

    public function getTimeSignature(): float
    {
        return $this->timeSignature;
    }

    public function getTimeSignatureConfidence(): float
    {
        return $this->timeSignatureConfidence;
    }
}
