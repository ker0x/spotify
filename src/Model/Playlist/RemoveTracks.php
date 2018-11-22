<?php

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class RemoveTracks implements JsonSerializable
{
    /**
     * @var array
     */
    private $tracks;

    /**
     * @var null|string
     */
    private $snapshotId;

    /**
     * RemoveTracks constructor.
     *
     * @param array       $tracks
     * @param null|string $snapshotId
     */
    public function __construct(array $tracks, ?string $snapshotId = null)
    {
        $this->tracks = $tracks;
        $this->snapshotId = $snapshotId;
    }

    /**
     * @param array       $tracks
     * @param null|string $snapshotId
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
        return [
            'tracks' => $this->tracks,
            'snapshot_id' => $this->snapshotId,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
