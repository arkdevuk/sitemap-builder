[![Latest Stable Version](http://poser.pugx.org/arkdevuk/sitemap-builder/v)](https://packagist.org/packages/arkdevuk/sitemap-builder) [![Total Downloads](http://poser.pugx.org/arkdevuk/sitemap-builder/downloads)](https://packagist.org/packages/arkdevuk/sitemap-builder) [![Latest Unstable Version](http://poser.pugx.org/arkdevuk/sitemap-builder/v/unstable)](https://packagist.org/packages/arkdevuk/sitemap-builder) [![License](http://poser.pugx.org/arkdevuk/sitemap-builder/license)](https://packagist.org/packages/arkdevuk/sitemap-builder) [![Made With](https://img.shields.io/badge/made_with-php-blue)](/docs/requirements/)
# Sitemap-build
a simple tool to generate sitemaps for google's bots


## USAGE

as simple as this : 
```php
<?php

namespace App;


require_once __DIR__ . '/../vendor/autoload.php';

use ArkdevukSitemapBuilder\classes\Sitemap;
use ArkdevukSitemapBuilder\classes\SitemapContainer;
use ArkdevukSitemapBuilder\classes\SitemapEntry;
use ArkdevukSitemapBuilder\classes\SitemapEntryImage;

$baseUrl = 'https://mywebsite.tld';

$container = new SitemapContainer($baseUrl, __DIR__.DIRECTORY_SEPARATOR.'example1');

$sitemap = new Sitemap('page');

$entry = new SitemapEntry();
$entry
    ->setLocation('/test')
    ->setChangeFrequency(SitemapEntry::CHANGE_WEEKLY)
    ->setPriority(1)
    ->setLastModDateTime(new \DateTime('2020-12-10'));

$media = new SitemapEntryImage($baseUrl.'/assets/images/image.jpeg');
$media
    ->setCaption('A test image for the purpose of the example')
    ->setGeoLocation('Aurillac, Cantal, France')
    ->setTitle('Image Title')//->setLicence('https://creativecommons.org/licenses/by-nc-nd/4.0/')
;

$entry->setMedia($media);

$sitemap->addEntry($entry);

$container->addSitemap($sitemap);


$container->compile();

```