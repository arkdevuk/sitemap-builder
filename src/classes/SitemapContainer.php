<?php /** @noinspection SlowArrayOperationsInLoopInspection */


namespace ArkdevukSitemapBuilder\classes;


use InvalidArgumentException;
use XMLWriter;

class SitemapContainer
{
    /**
     * base url ex : https://github.com
     * NO TRAILING SLASH
     *
     * @var string
     */
    protected string $baseUrl;
    /**
     * path were to output the files
     *
     * @var string
     */
    protected string $outputPath;

    /**
     * @var array|Sitemap[]
     */
    protected array $sitemaps;

    /**
     * SitemapContainer constructor.
     * @param string $baseUrl
     * @param string $outputPath
     * @throws InvalidArgumentException
     */
    public function __construct(string $baseUrl, string $outputPath)
    {
        $this->baseUrl = $baseUrl;
        $this->outputPath = $outputPath;
        if (!is_writable($this->outputPath)) {
            throw new InvalidArgumentException("Path ".$this->outputPath." is not writable by PHP.");
        }
        $this->sitemaps = [];
    }

    /**
     * add sitemap to container
     *
     * @param Sitemap $sitemap
     * @return SitemapContainer
     */
    public function addSitemap(Sitemap $sitemap): self
    {
        if (!in_array($sitemap, $this->sitemaps, true)) {
            $sitemap->setParent($this);
            $this->sitemaps[] = $sitemap;
        }

        return $this;
    }

    /**
     * @return Sitemap[]|array
     */
    public function getSitemaps()
    {
        return $this->sitemaps;
    }

    public function compile()
    {
        $files = [];
        foreach ($this->sitemaps as $sitemap) {
            if ($sitemap instanceof Sitemap) {
                $files = array_merge($files, $sitemap->compile());
            }
        }
        //done add all file into a sitemap_index
        $writer = new XMLWriter();
        $filename = $this->getOutputPath().DIRECTORY_SEPARATOR.'sitemap_index.xml';
        $writer->openURI($filename);
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->writePI('xml-stylesheet', 'href="'.$this->getBaseUrl().'/main-sitemap.xsl" type="text/xsl"');
        $writer->startElement('sitemapindex');
        $writer->writeAttribute('xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9");
        foreach ($files as $fileInfo) {
            $writer->startElement('sitemap');
            $writer->writeElement('loc', $this->getBaseUrl().'/'.$fileInfo['f']);
            if (isset($fileInfo['lm']) && $fileInfo['lm'] instanceof \DateTime) {
                $writer->writeElement('lastmod', $fileInfo['lm']->format(DATE_ATOM));
            }
            $writer->endElement();
        }
        $writer->endElement();
        $writer->writeComment('created with arkdevuk/sitemap-builder, see https://github.com/arkdevuk/sitemap-builder');
        $writer->endDocument();
    }

    /**
     * @return string
     */
    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    /**
     * @param string $outputPath
     * @return SitemapContainer
     */
    public function setOutputPath(string $outputPath): SitemapContainer
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return SitemapContainer
     */
    public function setBaseUrl(string $baseUrl): SitemapContainer
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }
}