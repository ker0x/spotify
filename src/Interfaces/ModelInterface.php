<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface ModelInterface
{
    /**
     * @return mixed
     */
    public static function build(array $model);
}
