<?php

declare(strict_types=1);

namespace Kerox\Spotify\Factory;

use Kerox\Spotify\Interfaces\ModelInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\Category;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\SavedAlbum;
use Kerox\Spotify\Model\SavedTrack;
use Kerox\Spotify\Model\Track;

class ItemFactory
{
    public const TYPES = [
        'album' => Album::class,
        'artist' => Artist::class,
        'track' => Track::class,
        'playlist' => Playlist::class,
    ];

    /**
     * @param array $item
     *
     * @return \Kerox\Spotify\Interfaces\ModelInterface
     */
    public static function create(array $item): ModelInterface
    {
        if (isset($item['type']) && \array_key_exists($item['type'], self::TYPES)) {
            $className = self::TYPES[$item['type']];

            return $className::build($item);
        }

        if (isset($item['added_at'])) {
            if (isset($item['album'])) {
                return SavedAlbum::build($item);
            }

            if (isset($item['track'])) {
                return SavedTrack::build($item);
            }
        }

        return Category::build($item);
    }
}
