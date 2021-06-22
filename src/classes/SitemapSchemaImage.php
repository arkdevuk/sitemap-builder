<?php


namespace ArkdevukSitemapBuilder\classes;


use ArkdevukSitemapBuilder\interfaces\SitemapSchema;

class SitemapSchemaImage implements SitemapSchema
{
    protected string $name = 'xmlns:image';
    protected string $value = "http://www.google.com/schemas/sitemap-image/1.1";
    protected string $schemaLocation = "http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd";
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