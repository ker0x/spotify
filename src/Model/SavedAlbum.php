<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Kerox\Spotify\Interfaces\ModelInterface;

class SavedAlbum implements ModelInterface
{
    /**
     * @var null|\DateTimeInterface
     */
    protected $addedAt;

    /**
     * @var \Kerox\Spotify\Model\Album
     */
    protected $album;

    /**
     * SavedTrack constructor.
     *
     * @param \Kerox\Spotify\Model\Album $album
     * @param null|\DateTimeInterface    $addedAt
     */
    public function __construct(Album $album, ?DateTimeInterface $addedAt = null)
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
        $album = Album::build($savedTrack['album']);
        $addedAt = DateTime::createFromFormat(
            DateTime::ATOM,
            $savedTrack['added_at'],
            new DateTimeZone('UTC')
        ) ?: null;

        return new self($album, $addedAt);
    }

    /**
     * @return null|\DateTimeInterface
     */
    public function getAddedAt(): ?DateTimeInterface
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
