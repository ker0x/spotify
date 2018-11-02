<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Context
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $href;

    /**
     * @var array
     */
    protected $externalUrls;

    /**
     * @var string
     */
    protected $uri;

    /**
     * Context constructor.
     *
     * @param string $type
     * @param string $href
     * @param array  $externalUrls
     * @param string $uri
     */
    public function __construct(string $type, string $href, array $externalUrls, string $uri)
    {
        $this->type = $type;
        $this->href = $href;
        $this->externalUrls = $externalUrls;
        $this->uri = $uri;
    }

    public static function create(array $context): self
    {
        $type = $context['type'];
        $href = $context['href'];

        $externalUrls = [];
        foreach ($context['external_urls'] as $externalUrl) {
            $externalUrls[] = External::create($externalUrl);
        }

        $uri = $context['uri'];

        return new self($type, $href, $externalUrls, $uri);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
