<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Recommendations
{
    /**
     * @var array
     */
    protected $seeds;

    /**
     * @var array
     */
    protected $tracks;

    /**
     * Recommendations constructor.
     *
     * @param array $seeds
     * @param array $tracks
     */
    public function __construct(array $seeds, array $tracks)
    {
        $this->seeds = $seeds;
        $this->tracks = $tracks;
    }

    /**
     * @param array $recommendations
     *
     * @return \Kerox\Spotify\Model\Recommendations
     */
    public static function create(array $recommendations): self
    {
        $tracks = [];
        foreach ($recommendations['tracks'] as $track) {
            $tracks[] = Track::create($track);
        }

        $seeds = [];
        foreach ($recommendations['seeds'] as $seed) {
            $seeds[] = RecommandationsSeed::create($seed);
        }

        return new self($tracks, $seeds);
    }

    /**
     * @return array
     */
    public function getSeeds(): array
    {
        return $this->seeds;
    }

    /**
     * @return array
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }
}
