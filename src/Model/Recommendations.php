<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Model\ModelInterface;

class Recommendations implements ModelInterface
{
    /**
     * @var array
     */
    protected $tracks;

    /**
     * @var array
     */
    protected $seeds;

    /**
     * Recommendations constructor.
     *
     * @param array $tracks
     * @param array $seeds
     */
    public function __construct(array $tracks, array $seeds)
    {
        $this->tracks = $tracks;
        $this->seeds = $seeds;
    }

    /**
     * @param array $recommendations
     *
     * @return \Kerox\Spotify\Model\Recommendations
     */
    public static function build(array $recommendations): self
    {
        $tracks = [];
        foreach ($recommendations['tracks'] as $track) {
            $tracks[] = Track::build($track);
        }

        $seeds = [];
        foreach ($recommendations['seeds'] as $seed) {
            $seeds[] = Seed::build($seed);
        }

        return new self($tracks, $seeds);
    }

    /**
     * @return \Kerox\Spotify\Model\Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @return \Kerox\Spotify\Model\Seed[]
     */
    public function getSeeds(): array
    {
        return $this->seeds;
    }
}
