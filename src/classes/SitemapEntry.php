<?php

namespace ArkdevukSitemapBuilder\classes;

use ArkdevukSitemapBuilder\interfaces\SitemapEntryMedia;

class SitemapEntry
{
    public const CHANGE_NEVER = -1;
    public const CHANGE_ALWAYS = 1;

    public const CHANGE_HOURLY = 2;
    public const CHANGE_DAILY = 3;
    public const CHANGE_WEEKLY = 4;
    public const CHANGE_MONTHLY = 5;
    public const CHANGE_YEARLY = 6;


    /**
     * @var string
     */
    protected string $location = '';
    /**
     * @var float
     */
    protected float $priority = 0.5;
    /**
     * @var int
     */
    protected int $changeFrequency = self::CHANGE_WEEKLY;
    /**
     * @var null|\DateTime
     */
    protected ?\DateTime $lastModDateTime;

    /**
     * Contient toutes les informations sur une seule image|video.
     *
     * @var SitemapEntryMedia|null
     */
    protected ?SitemapEntryMedia $media;

    public function __construct()
    {
        $this->media = null;
        $this->lastModDateTime = null;
    }

    /**
     * @param string $location
     * @return SitemapEntry
     */
    public function setLocation(string $location): SitemapEntry
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param float $priority
     * @return SitemapEntry
     */
    public function setPriority(float $priority): SitemapEntry
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriority(): float
    {
        return $this->priority;
    }

    /**
     * @param int $changeFrequency
     * @return SitemapEntry
     */
    public function setChangeFrequency(int $changeFrequency): SitemapEntry
    {
        $this->changeFrequency = $changeFrequency;

        return $this;
    }

    /**
     * @return int
     */
    public function getChangeFrequency(): int
    {
        return $this->changeFrequency;
    }

    /**
     * @param \DateTime|null $lastModDateTime
     * @return SitemapEntry
     */
    public function setLastModDateTime(?\DateTime $lastModDateTime): SitemapEntry
    {
        $this->lastModDateTime = $lastModDateTime;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastModDateTime(): ?\DateTime
    {
        return $this->lastModDateTime;
    }

    /**
     * @param SitemapEntryMedia|null $media
     * @return SitemapEntry
     */
    public function setMedia(?SitemapEntryMedia $media): SitemapEntry
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return SitemapEntryMedia|null
     */
    public function getMedia(): ?SitemapEntryMedia
    {
        return $this->media;
    }
}