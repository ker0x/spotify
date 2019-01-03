<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class Category implements ModelInterface
{
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
     *
     * @param string $href
     * @param array  $icons
     * @param string $id
     * @param string $name
     */
    public function __construct(string $href, array $icons, string $id, string $name)
    {
        $this->href = $href;
        $this->icons = $icons;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array $category
     *
     * @return \Kerox\Spotify\Model\Category
     */
    public static function build(array $category): self
    {
        $href = $category['href'];

        $icons = [];
        foreach ($category['icons'] as $icon) {
            $icons[] = Image::build($icon);
        }

        $id = $category['id'];
        $name = $category['name'];

        return new self($href, $icons, $id, $name);
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return array
     */
    public function getIcons(): array
    {
        return $this->icons;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
