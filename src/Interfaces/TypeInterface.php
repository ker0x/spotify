<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface TypeInterface
{
    public const TYPE_ALBUM = 'album';
    public const TYPE_ARTIST = 'artist';
    public const TYPE_ARTISTS = 'artists';
    public const TYPE_PLAYLIST = 'playlist';
    public const TYPE_TRACK = 'track';
    public const TYPE_TRACKS = 'tracks';
    public const TYPE_USER = 'user';
}
