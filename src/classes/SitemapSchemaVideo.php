<?php


namespace ArkdevukSitemapBuilder\classes;


use ArkdevukSitemapBuilder\interfaces\SitemapSchema;

class SitemapSchemaVideo implements SitemapSchema
{
    protected string $name = 'xmlns:video';
    protected string $value = "http://www.google.com/schemas/sitemap-video/1.1";
    protected string $schemaLocation = "http://www.google.com/schemas/sitemap-video/1.1 https://www.google.com/schemas/sitemap-video/1.1/sitemap-video.xsd";
    protected bool $forceXSI_ = true;


    public function getAttributeName(): string
    {
        return $this->name;
    }

    public function getAttributeValue(): string
    {
        return $this->value;
    }

    public function getSchemaLocation(): string
    {
        return $this->schemaLocation;
    }

    public function forceXSI(): bool
    {
        return $this->forceXSI_;
    }
}