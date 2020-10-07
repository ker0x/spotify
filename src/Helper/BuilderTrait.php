<?php

declare(strict_types=1);

namespace Kerox\Spotify\Helper;

use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Followers;
use Kerox\Spotify\Model\Image;

trait BuilderTrait
{
    /**
     * @return \Kerox\Spotify\Model\External[]
     */
    public static function buildExternal(array $externalTypeArray): array
    {
        $externals = [];
        foreach ($externalTypeArray as $key => $value) {
            $externals[] = External::build([$key, $value]);
        }

        return $externals;
    }

    /**
     * @return \Kerox\Spotify\Model\Image[]
     */
    public static function buildImages(array $imagesArray): array
    {
        $images = [];
        foreach ($imagesArray as $image) {
            $images[] = Image::build($image);
        }

        return $images;
    }

    public static function buildFollowers(?array $followersArray): ?Followers
    {
        if (\is_array($followersArray)) {
            return Followers::build($followersArray);
        }

        return null;
    }
}
