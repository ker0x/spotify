<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class Seed implements ModelInterface
{
    /**
     * @var int
     */
    protected $afterFilteringSize;

    /**
     * @var int
     */
    protected $afterRelinkingSize;

    /**
     * @var string|null
     */
    protected $href;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $initialPoolSize;

    /**
     * @var string
     */
    protected $type;

    /**
     * RecommandationsSeed constructor.
     *
     * @param int         $afterFilteringSize
     * @param int         $afterRelinkingSize
     * @param string|null $href
     * @param string      $id
     * @param int         $initialPoolSize
     * @param string      $type
     */
    public function __construct(
        int $afterFilteringSize,
        int $afterRelinkingSize,
        ?string $href,
        string $id,
        int $initialPoolSize,
        string $type
    ) {
        $this->afterFilteringSize = $afterFilteringSize;
        $this->afterRelinkingSize = $afterRelinkingSize;
        $this->id = $id;
        $this->initialPoolSize = $initialPoolSize;
        $this->type = $type;
        $this->href = $href;
    }

    /**
     * @param array $recommendationsSeed
     *
     * @return \Kerox\Spotify\Model\Seed
     */
    public static function build(array $recommendationsSeed): self
    {
        $afterFilteringSize = $recommendationsSeed['afterFilteringSize'];
        $afterRelinkingSize = $recommendationsSeed['afterRelinkingSize'];
        $href = $recommendationsSeed['href'];
        $id = $recommendationsSeed['id'];
        $initialPoolSize = $recommendationsSeed['initialPoolSize'];
        $type = $recommendationsSeed['type'];

        return new self(
            $afterFilteringSize,
            $afterRelinkingSize,
            $href,
            $id,
            $initialPoolSize,
            $type
        );
    }

    /**
     * @return int
     */
    public function getAfterFilteringSize(): int
    {
        return $this->afterFilteringSize;
    }

    /**
     * @return int
     */
    public function getAfterRelinkingSize(): int
    {
        return $this->afterRelinkingSize;
    }

    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getInitialPoolSize(): int
    {
        return $this->initialPoolSize;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
