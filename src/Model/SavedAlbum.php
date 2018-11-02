<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class SavedAlbum
{
    /**
     * @var \DateTimeInterface
     */
    protected $addedAt;

    /**
     * @var \Kerox\Spotify\Model\Album
     */
    protected $album;

    /**
     * SavedTrack constructor.
     *
     * @param \DateTimeInterface         $addedAt
     * @param \Kerox\Spotify\Model\Album $album
     */
    public function __construct(DateTimeInterface $addedAt, Album $album)
    {
        $this->addedAt = $addedAt;
        $this->album = $album;
    }

    /**
     * @param array $savedTrack
     *
     * @return \Kerox\Spotify\Model\SavedAlbum
     */
    public static function create(array $savedTrack): self
    {
        $addedAt = DateTimeImmutable::createFromFormat(
            DateTimeInterface::ATOM,
            $savedTrack['added_at'],
            DateTimeZone::UTC
        );
        $album = Album::create($savedTrack['album']);

        return new self($addedAt, $album);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getAddedAt(): DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @return \Kerox\Spotify\Model\Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }
}
