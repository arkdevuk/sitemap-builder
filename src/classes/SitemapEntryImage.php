<?php

namespace ArkdevukSitemapBuilder\classes;

use ArkdevukSitemapBuilder\interfaces\SitemapEntryMedia;

class SitemapEntryImage implements SitemapEntryMedia
{
    /**
     * URL de l'image
     * Dans certains cas, il se peut que l'URL de l'image ne se trouve pas sur le même domaine que votre site principal.
     * Cela ne pose aucun problème, à condition que les deux domaines aient été validés dans la Search Console.
     * Si, par exemple, vous utilisez un réseau de diffusion de contenu tel que Google Sites pour héberger vos images,
     * assurez-vous d'avoir validé ce site dans la Search Console. De plus, assurez-vous que votre fichier robots.txt
     * n'empêche pas l'exploration du contenu que vous souhaitez indexer.
     *
     * @var string
     */
    protected string $location;
    /**
     * Légende de l'image.
     *
     * @var null|string
     */
    protected ?string $caption;
    /**
     * Emplacement géographique de l'image. Exemple : <image:geo_location>Limerick, Ireland</image:geo_location>.
     *
     * @var null|string
     */
    protected ?string $geoLocation;
    /**
     * Titre de l'image.
     *
     * @var null|string
     */
    protected ?string $title;
    /**
     * URL qui renvoie à la licence de l'image. Si vous le souhaitez, vous pouvez utiliser les métadonnées d'image.
     * @see https://developers.google.com/search/docs/advanced/appearance/image-rights-metadata?hl=fr
     *
     * @var null|string
     */
    protected ?string $licence;

    public function __construct(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return SitemapEntryImage
     */
    public function setLocation(string $location): SitemapEntryImage
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param string|null $caption
     * @return SitemapEntryImage
     */
    public function setCaption(?string $caption): SitemapEntryImage
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $geoLocation
     * @return SitemapEntryImage
     */
    public function setGeoLocation(?string $geoLocation): SitemapEntryImage
    {
        $this->geoLocation = $geoLocation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGeoLocation(): ?string
    {
        return $this->geoLocation;
    }

    /**
     * @param string|null $title
     * @return SitemapEntryImage
     */
    public function setTitle(?string $title): SitemapEntryImage
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $licence
     * @return SitemapEntryImage
     */
    public function setLicence(?string $licence): SitemapEntryImage
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicence(): ?string
    {
        return $this->licence;
    }
}