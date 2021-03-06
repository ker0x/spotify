<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\User;

class UserResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\User
     */
    protected $user;

    public function getUser(): User
    {
        return $this->user;
    }

    protected function parseResponse(array $content): void
    {
        $this->user = User::build($content);
    }
}
