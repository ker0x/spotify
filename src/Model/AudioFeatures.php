<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class AudioFeatures implements ModelInterface
{
    /**
     * @var float
     */
    protected $acousticness;

    /**
     * @var string
     */
    protected $analysisUrl;

    /**
     * @var float
     */
    protected $danceability;

    /**
     * @var int
     */
    protected $durationMs;

    /**
     * @var float
     */
    protected $energy;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var float
     */
    protected $instrumentalness;

    /**
     * @var int
     */
    protected $key;

    /**
     * @var float
     */
    protected $liveness;

    /**
     * @var float
     */
    protected $loudness;

    /**
     * @var int
     */
    protected $mode;

    /**
     * @var float
     */
    protected $speechiness;

    /**
     * @var float
     */
    protected $tempo;

    /**
     * @var int
     */
    protected $timeSignature;

    /**
     * @var string
     */
    protected $trackHref;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var float
     */
    protected $valence;

    /**
     * AudioFeatures constructor.
     */
    public function __construct(
        float $acousticness,
        string $analysisUrl,
        float $danceability,
        int $durationMs,
        float $energy,
        string $id,
        float $instrumentalness,
        int $key,
        float $liveness,
        float $loudness,
        int $mode,
        float $speechiness,
        float $tempo,
        int $timeSignature,
        string $trackHref,
        string $type,
        string $uri,
        float $valence
    ) {
        $this->acousticness = $acousticness;
        $this->analysisUrl = $analysisUrl;
        $this->danceability = $danceability;
        $this->durationMs = $durationMs;
        $this->energy = $energy;
        $this->id = $id;
        $this->instrumentalness = $instrumentalness;
        $this->key = $key;
        $this->liveness = $liveness;
        $this->loudness = $loudness;
        $this->mode = $mode;
        $this->speechiness = $speechiness;
        $this->tempo = $tempo;
        $this->timeSignature = $timeSignature;
        $this->trackHref = $trackHref;
        $this->type = $type;
        $this->uri = $uri;
        $this->valence = $valence;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioFeatures
     */
    public static function build(array $audioFeatures): self
    {
        $acousticness = $audioFeatures['acousticness'];
        $analysisUrl = $audioFeatures['analysis_url'];
        $danceability = $audioFeatures['danceability'];
        $durationMs = $audioFeatures['duration_ms'];
        $energy = $audioFeatures['energy'];
        $id = $audioFeatures['id'];
        $instrumentalness = $audioFeatures['instrumentalness'];
        $key = $audioFeatures['key'];
        $liveness = $audioFeatures['liveness'];
        $loudness = $audioFeatures['loudness'];
        $mode = $audioFeatures['mode'];
        $speechiness = $audioFeatures['speechiness'];
        $tempo = $audioFeatures['tempo'];
        $timeSignature = $audioFeatures['time_signature'];
        $trackHref = $audioFeatures['track_href'];
        $type = $audioFeatures['type'];
        $uri = $audioFeatures['uri'];
        $valence = $audioFeatures['valence'];

        return new self(
            $acousticness,
            $analysisUrl,
            $danceability,
            $durationMs,
            $energy,
            $id,
            $instrumentalness,
            $key,
            $liveness,
            $loudness,
            $mode,
            $speechiness,
            $tempo,
            $timeSignature,
            $trackHref,
            $type,
            $uri,
            $valence
        );
    }

    public function getAcousticness(): float
    {
        return $this->acousticness;
    }

    public function getAnalysisUrl(): string
    {
        return $this->analysisUrl;
    }

    public function getDanceability(): float
    {
        return $this->danceability;
    }

    public function getDurationMs(): int
    {
        return $this->durationMs;
    }

    public function getEnergy(): float
    {
        return $this->energy;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getInstrumentalness(): float
    {
        return $this->instrumentalness;
    }

    public function getKey(): int
    {
        return $this->key;
    }

    public function getLiveness(): float
    {
        return $this->liveness;
    }

    public function getLoudness(): float
    {
        return $this->loudness;
    }

    public function getMode(): int
    {
        return $this->mode;
    }

    public function getSpeechiness(): float
    {
        return $this->speechiness;
    }

    public function getTempo(): float
    {
        return $this->tempo;
    }

    public function getTimeSignature(): int
    {
        return $this->timeSignature;
    }

    public function getTrackHref(): string
    {
        return $this->trackHref;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getValence(): float
    {
        return $this->valence;
    }
}
