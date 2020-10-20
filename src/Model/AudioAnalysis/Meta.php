<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

use Kerox\Spotify\Interfaces\ModelInterface;

class Meta implements ModelInterface
{
    /**
     * @var string
     */
    protected $analyzerVersion;

    /**
     * @var string
     */
    protected $platform;

    /**
     * @var string
     */
    protected $detailedStatus;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var float
     */
    protected $analysisTime;

    /**
     * @var string
     */
    protected $inputProcess;

    /**
     * Meta constructor.
     */
    public function __construct(
        string $analyzerVersion,
        string $platform,
        string $detailedStatus,
        int $statusCode,
        int $timestamp,
        float $analysisTime,
        string $inputProcess
    ) {
        $this->analyzerVersion = $analyzerVersion;
        $this->platform = $platform;
        $this->detailedStatus = $detailedStatus;
        $this->statusCode = $statusCode;
        $this->timestamp = $timestamp;
        $this->analysisTime = $analysisTime;
        $this->inputProcess = $inputProcess;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Meta
     */
    public static function build(array $meta): self
    {
        return new self(
            $meta['analyzer_version'],
            $meta['platform'],
            $meta['detailed_status'],
            $meta['status_code'],
            $meta['timestamp'],
            $meta['analysis_time'],
            $meta['input_process']
        );
    }

    public function getAnalyzerVersion(): string
    {
        return $this->analyzerVersion;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function getDetailedStatus(): string
    {
        return $this->detailedStatus;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getAnalysisTime(): float
    {
        return $this->analysisTime;
    }

    public function getInputProcess(): string
    {
        return $this->inputProcess;
    }
}
