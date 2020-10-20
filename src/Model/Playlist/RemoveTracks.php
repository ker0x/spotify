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
     */
    public function __construct(array $tracks, ?string $snapshotId = null)
    {
        $this->tracks = $tracks;
        $this->snapshotId = $snapshotId;
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\RemoveTracks
     */
    public static function create(array $tracks, ?string $snapshotId = null): self
    {
        return new self($tracks, $snapshotId);
    }

    public function toArray(): array
    {
        $array = [
            'tracks' => $this->tracks,
            'snapshot_id' => $this->snapshotId,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
