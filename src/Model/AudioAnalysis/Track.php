<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

use Kerox\Spotify\Interfaces\ModelInterface;

class Track implements ModelInterface
{
    /**
     * @var int
     */
    protected $numSamples;

    /**
     * @var float
     */
    protected $duration;

    /**
     * @var string
     */
    protected $sampleMd5;

    /**
     * @var int
     */
    protected $offsetSeconds;

    /**
     * @var int
     */
    protected $windowSeconds;

    /**
     * @var int
     */
    protected $analysisSampleRate;

    /**
     * @var int
     */
    protected $analysisChannels;

    /**
     * @var float
     */
    protected $endOfFadeIn;

    /**
     * @var float
     */
    protected $startOfFadeOut;

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
    protected $timeSignature;

    /**
     * @var float
     */
    protected $timeSignatureConfidence;

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
     * @var string
     */
    protected $codeString;

    /**
     * @var float
     */
    protected $codeVersion;

    /**
     * @var string
     */
    protected $echoPrintString;

    /**
     * @var float
     */
    protected $echoPrintVersion;

    /**
     * @var string
     */
    protected $synchString;

    /**
     * @var float
     */
    protected $synchVersion;

    /**
     * @var string
     */
    protected $rhythmString;

    /**
     * @var float
     */
    protected $rhythmVersion;

    /**
     * Track constructor.
     */
    public function __construct(
        int $numSamples,
        float $duration,
        string $sampleMd5,
        int $offsetSeconds,
        int $windowSeconds,
        int $analysisSampleRate,
        int $analysisChannels,
        float $endOfFadeIn,
        float $startOfFadeOut,
        float $loudness,
        float $tempo,
        float $tempoConfidence,
        float $timeSignature,
        float $timeSignatureConfidence,
        float $key,
        float $keyConfidence,
        float $mode,
        float $modeConfidence,
        string $codeString,
        float $codeVersion,
        string $echoPrintString,
        float $echoPrintVersion,
        string $synchString,
        float $synchVersion,
        string $rhythmString,
        float $rhythmVersion
    ) {
        $this->numSamples = $numSamples;
        $this->duration = $duration;
        $this->sampleMd5 = $sampleMd5;
        $this->offsetSeconds = $offsetSeconds;
        $this->windowSeconds = $windowSeconds;
        $this->analysisSampleRate = $analysisSampleRate;
        $this->analysisChannels = $analysisChannels;
        $this->endOfFadeIn = $endOfFadeIn;
        $this->startOfFadeOut = $startOfFadeOut;
        $this->loudness = $loudness;
        $this->tempo = $tempo;
        $this->tempoConfidence = $tempoConfidence;
        $this->timeSignature = $timeSignature;
        $this->timeSignatureConfidence = $timeSignatureConfidence;
        $this->key = $key;
        $this->keyConfidence = $keyConfidence;
        $this->mode = $mode;
        $this->modeConfidence = $modeConfidence;
        $this->codeString = $codeString;
        $this->codeVersion = $codeVersion;
        $this->echoPrintString = $echoPrintString;
        $this->echoPrintVersion = $echoPrintVersion;
        $this->synchString = $synchString;
        $this->synchVersion = $synchVersion;
        $this->rhythmString = $rhythmString;
        $this->rhythmVersion = $rhythmVersion;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Track
     */
    public static function build(array $track): self
    {
        return new self(
            $track['num_samples'],
            $track['duration'],
            $track['sample_md5'],
            $track['offset_seconds'],
            $track['window_seconds'],
            $track['analysis_sample_rate'],
            $track['analysis_channels'],
            $track['end_of_fade_in'],
            $track['start_of_fade_out'],
            $track['loudness'],
            $track['tempo'],
            $track['tempo_confidence'],
            $track['time_signature'],
            $track['time_signature_confidence'],
            $track['key'],
            $track['key_confidence'],
            $track['mode'],
            $track['mode_confidence'],
            $track['codestring'],
            $track['code_version'],
            $track['echoprintstring'],
            $track['echoprint_version'],
            $track['synchstring'],
            $track['synch_version'],
            $track['rhythmstring'],
            $track['rhythm_version']
        );
    }

    public function getNumSamples(): int
    {
        return $this->numSamples;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function getSampleMd5(): string
    {
        return $this->sampleMd5;
    }

    public function getOffsetSeconds(): int
    {
        return $this->offsetSeconds;
    }

    public function getWindowSeconds(): int
    {
        return $this->windowSeconds;
    }

    public function getAnalysisSampleRate(): int
    {
        return $this->analysisSampleRate;
    }

    public function getAnalysisChannels(): int
    {
        return $this->analysisChannels;
    }

    public function getEndOfFadeIn(): float
    {
        return $this->endOfFadeIn;
    }

    public function getStartOfFadeOut(): float
    {
        return $this->startOfFadeOut;
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

    public function getTimeSignature(): float
    {
        return $this->timeSignature;
    }

    public function getTimeSignatureConfidence(): float
    {
        return $this->timeSignatureConfidence;
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

    public function getCodeString(): string
    {
        return $this->codeString;
    }

    public function getCodeVersion(): float
    {
        return $this->codeVersion;
    }

    public function getEchoPrintString(): string
    {
        return $this->echoPrintString;
    }

    public function getEchoPrintVersion(): float
    {
        return $this->echoPrintVersion;
    }

    public function getSynchString(): string
    {
        return $this->synchString;
    }

    public function getSynchVersion(): float
    {
        return $this->synchVersion;
    }

    public function getRhythmString(): string
    {
        return $this->rhythmString;
    }

    public function getRhythmVersion(): float
    {
        return $this->rhythmVersion;
    }
}
