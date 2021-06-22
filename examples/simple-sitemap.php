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

