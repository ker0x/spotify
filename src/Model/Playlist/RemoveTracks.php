<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class RemoveTracks implements JsonSerializable
{
    /**
     * @var array
     */
    private $tracks;

    /**
     * @var string|null
     */
    private $snapshotId;

    /**
     * RemoveTracks constructor.
     *
     * @param array       $tracks
     * @param string|null $snapshotId
     */
    public function __construct(array $tracks, ?string $snapshotId = null)
    {
        $this->tracks = $tracks;
        $this->snapshotId = $snapshotId;
    }

    /**
     * @param array       $tracks
     * @param string|null $snapshotId
     *
     * @return \Kerox\Spotify\Model\Playlist\RemoveTracks
     */
    public static function create(array $tracks, ?string $snapshotId = null): self
    {
        return new self($tracks, $snapshotId);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'tracks' => $this->tracks,
            'snapshot_id' => $this->snapshotId,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
