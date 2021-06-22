<?php


namespace ArkdevukSitemapBuilder\classes;


use ArkdevukSitemapBuilder\interfaces\SitemapSchema;

class SitemapSchemaSitemap implements SitemapSchema
{
    protected string $name = 'xmlns';
    protected string $value = "http://www.sitemaps.org/schemas/sitemap/0.9";
    protected string $schemaLocation = "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd";
    protected bool $forceXSI_ = false;


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