<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class SavedTrack
{
    /**
     * @var \DateTimeInterface
     */
    protected $addedAt;

    /**
     * @var \Kerox\Spotify\Model\Track
     */
    protected $track;

    /**
     * SavedTrack constructor.
     *
     * @param \DateTimeInterface         $addedAt
     * @param \Kerox\Spotify\Model\Track $track
     */
    public function __construct(DateTimeInterface $addedAt, Track $track)
    {
        $this->addedAt = $addedAt;
        $this->track = $track;
    }

    /**
     * @param array $savedTrack
     *
     * @return \Kerox\Spotify\Model\SavedTrack
     */
    public static function create(array $savedTrack): self
    {
        $addedAt = DateTimeImmutable::createFromFormat(
            DateTimeInterface::ATOM,
            $savedTrack['added_at'],
            DateTimeZone::UTC
        );
        $track = Track::create($savedTrack['track']);

        return new self($addedAt, $track);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getAddedAt(): \DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @return \Kerox\Spotify\Model\Track
     */
    public function getTrack(): Track
    {
        return $this->track;
    }
}
