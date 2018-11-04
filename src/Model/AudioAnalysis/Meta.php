<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\AudioAnalysis;

class Meta
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
     *
     * @param string $analyzerVersion
     * @param string $platform
     * @param string $detailedStatus
     * @param int    $statusCode
     * @param int    $timestamp
     * @param float  $analysisTime
     * @param string $inputProcess
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
     * @param array $meta
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Meta
     */
    public static function create(array $meta): self
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

    /**
     * @return string
     */
    public function getAnalyzerVersion(): string
    {
        return $this->analyzerVersion;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getDetailedStatus(): string
    {
        return $this->detailedStatus;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function getAnalysisTime(): float
    {
        return $this->analysisTime;
    }

    /**
     * @return string
     */
    public function getInputProcess(): string
    {
        return $this->inputProcess;
    }
}
