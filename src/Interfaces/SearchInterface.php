<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface SearchInterface
{
    public const TYPE_ALBUM = 'album';
    public const TYPE_ARTIST = 'artist';
    public const TYPE_PLAYLIST = 'playlist';
    public const TYPE_TRACK = 'track';
}
