<?php


namespace ArkdevukSitemapBuilder\interfaces;


interface SitemapSchema
{
    public function getAttributeName(): string;

    public function getAttributeValue(): string;

    public function getSchemaLocation(): string;

    public function forceXSI(): bool;
}