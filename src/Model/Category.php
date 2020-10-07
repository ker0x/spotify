<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Helper\BuilderTrait;

class Category implements ModelInterface
{
    use BuilderTrait;

    /**
     * @var string
     */
    protected $href;

    /**
     * @var \Kerox\Spotify\Model\Image[]
     */
    protected $icons;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Category constructor.
     */
    public function __construct(string $href, array $icons, string $id, string $name)
    {
        $this->href = $href;
        $this->icons = $icons;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return \Kerox\Spotify\Model\Category
     */
    public static function build(array $category): self
    {
        $icons = self::buildImages($category['icons'] ?? []);
        $href = $category['href'];
        $id = $category['id'];
        $name = $category['name'];

        return new self($href, $icons, $id, $name);
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getIcons(): array
    {
        return $this->icons;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
