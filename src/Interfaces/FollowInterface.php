<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface FollowInterface
{
    public const TYPE_ARTIST = 'artist';
    public const TYPE_PLAYLIST = 'playlist';
    public const TYPE_USER = 'user';
}
