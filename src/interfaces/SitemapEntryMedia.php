<?php

namespace ArkdevukSitemapBuilder\interfaces;


interface SitemapEntryMedia
{
    public function compile(\XMLWriter $writer): \XMLWriter;
}