<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTime;
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
    public static function build(array $savedTrack): self
    {
        $addedAt = DateTime::createFromFormat(
            DateTime::ATOM,
            $savedTrack['added_at'],
            new DateTimeZone('UTC')
        );
        $album = Album::build($savedTrack['album']);

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
