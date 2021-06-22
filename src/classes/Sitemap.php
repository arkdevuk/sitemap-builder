<?php


namespace ArkdevukSitemapBuilder\classes;


use ArkdevukSitemapBuilder\interfaces\SitemapSchema;
use XMLWriter;

class Sitemap
{
    protected array $entries = [];
    protected array $schemas = [];

    protected string $name;

    protected ?string $path;
    protected ?string $baseUrl;


    protected int $maxPerFile = 50000;
    protected string $extension = 'xml';
    protected string $separator = '-';


    /**
     * Parent of the current sitemap
     *
     * @var null|SitemapContainer
     */
    protected ?SitemapContainer $parent;
    /**
     * set this variable with the latest "lastmod" so parent can be aware of modification
     * @var null|\DateTime
     */
    private ?\DateTime $lastModDate;
    /**
     * represent the actual file if there's too many entries
     *
     * @var int
     */
    private int $fileId = 0;


    public function __construct(string $name)
    {
        $this->name = $name;

        $schema = new SitemapSchemaSitemap();
        $this->addSchema($schema);

    }

    /**
     * add schema to sitemap
     *
     * @param SitemapSchema $schema
     * @return Sitemap
     */
    public function addSchema(SitemapSchema $schema): self
    {
        if (!in_array($schema, $this->schemas, true)) {
            $this->schemas[] = $schema;
        }

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function compile(): array
    {
        $outputedFiles = [];

        //precompile header
        $xmlns = [];
        $xsiLocations = [];
        $forceXSI = false;

        $lastMod = $this->getLastMod();

        foreach ($this->schemas as $schema) {
            if ($schema instanceof SitemapSchema) {
                $name = $schema->getAttributeName();
                if (!isset($xmlns[$name])) {
                    $xmlns[$name] = [];
                }

                if (!in_array($schema->getAttributeValue(), $xmlns[$name], true)) {
                    $xmlns[$name][] = $schema->getAttributeValue();
                }

                if (!in_array($schema->getSchemaLocation(), $xsiLocations, true)) {
                    $xsiLocations[] = $schema->getSchemaLocation();
                }

                if ($schema->forceXSI()) {
                    $forceXSI = true;
                }
            }
        }

        //loop for each file
        $pipeline = array_chunk($this->entries, $this->maxPerFile);
        foreach ($pipeline as $entriesForCurrentFile) {
            $writer = new XMLWriter();
            if (count($pipeline) >= 2) {
                $filename = 'sitemap'
                    .$this->getSeparator().$this->getName().$this->getSeparator()
                    .$this->getFileId().'.'.$this->getExtension();
                $writer->openURI(
                    $this->getPath().DIRECTORY_SEPARATOR.'sitemap'
                    .$this->getSeparator().$this->getName().$this->getSeparator()
                    .$this->getFileId().'.'.$this->getExtension()
                );
            } else {
                $filename = 'sitemap'
                    .$this->getSeparator().$this->getName().'.'.$this->getExtension();
                $writer->openURI(
                    $this->getPath().DIRECTORY_SEPARATOR.'sitemap'
                    .$this->getSeparator().$this->getName().'.'.$this->getExtension()
                );
            }
            $outputedFiles[] = ['f' => $filename, 'lm' => $lastMod];
            $writer->startDocument('1.0', 'UTF-8');
            $writer->setIndent(true);
            $writer->writePI('xml-stylesheet', 'href="'.$this->getBaseUrl().'/main-sitemap.xsl" type="text/xsl"');
            $writer->startElement('urlset');


            foreach ($xmlns as $name => $values) {
                $writer->writeAttribute($name, implode(' ', $values));
            }
            if ($forceXSI) {
                $writer->writeAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
                $writer->writeAttribute('xsi:schemaLocation', implode(' ', $xsiLocations));
            }

            foreach ($entriesForCurrentFile as $currentEntry) {
                if ($currentEntry instanceof SitemapEntry) {
                    $writer->startElement('url');

                    $loc = $currentEntry->getLocation();
                    if ($loc[0] !== '/') {
                        $loc = '/'.$loc;
                    }
                    $writer->writeElement('loc', $this->getBaseUrl().$loc);

                    switch ($currentEntry->getChangeFrequency()) {
                        case SitemapEntry::CHANGE_NEVER:
                            $cf = 'never';
                            break;
                        case SitemapEntry::CHANGE_ALWAYS:
                            $cf = 'always';
                            break;
                        case SitemapEntry::CHANGE_HOURLY:
                            $cf = 'hourly';
                            break;
                        case SitemapEntry::CHANGE_DAILY:
                            $cf = 'daily';
                            break;
                        case SitemapEntry::CHANGE_WEEKLY:
                            $cf = 'weekly';
                            break;
                        case SitemapEntry::CHANGE_MONTHLY:
                            $cf = 'monthly';
                            break;
                        case SitemapEntry::CHANGE_YEARLY:
                            $cf = 'yearly';
                            break;
                        default:
                            $cf = null;
                    }
                    if ($cf !== null) {
                        $writer->writeElement('changefreq', $cf);
                    }

                    $writer->writeElement('priority', $currentEntry->getPriority());

                    if ($currentEntry->getLastModDateTime() !== null) {
                        $writer->writeElement('lastmod', $currentEntry->getLastModDateTime()->format(DATE_ATOM));
                    }

                    if ($currentEntry->getMedia() !== null) {
                        $writer = $currentEntry->getMedia()->compile($writer);
                    }

                    $writer->endElement();
                }
            }


            $writer->endElement();
            $writer->writeComment(
                'created with arkdevuk/sitemap-builder, see https://github.com/arkdevuk/sitemap-builder'
            );
            $writer->endDocument();

        }

        return $outputedFiles;
    }

    /**
     * return the last datetime mod for the current stack
     *
     * @return \DateTime
     * @throws \Exception
     */
    public function getLastMod(): \DateTime
    {
        $lastMod = new \DateTime('1991-01-01');

        foreach ($this->entries as $entry) {
            if ($entry instanceof SitemapEntry) {
                $lm = $entry->getLastModDateTime();
                if ($lm !== null && $lm > $lastMod) {
                    $lastMod = $lm;
                }
            }
        }

        return $lastMod;
    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     * @return Sitemap
     */
    public function setSeparator(string $separator): Sitemap
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getFileId(): int
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return Sitemap
     */
    public function setExtension(string $extension): Sitemap
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        if ($this->parent !== null) {
            return $this->parent->getOutputPath();
        }

        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Sitemap
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        if ($this->parent !== null) {
            return $this->parent->getBaseUrl();
        }

        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     * @return Sitemap
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastModDate()
    {
        return $this->lastModDate;
    }

    /**
     * @return SitemapContainer|null
     */
    public function getParent(): ?SitemapContainer
    {
        return $this->parent;
    }

    /**
     * @param SitemapContainer|null $parent
     * @return Sitemap
     */
    public function setParent(?SitemapContainer $parent): Sitemap
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * add an entry to the current stack & add a new schema if needed
     *
     * @param SitemapEntry $entry
     * @return Sitemap
     */
    public function addEntry(SitemapEntry $entry): self
    {
        if (!in_array($entry, $this->entries, true)) {
            if ($entry->getMedia() !== null) {
                if ($entry->getMedia() instanceof SitemapEntryImage) {
                    $schema = new SitemapSchemaImage();
                    $this->addSchema($schema);
                } else {
                    if ($entry->getMedia() instanceof SitemapEntryVideo) {
                        $schema = new SitemapSchemaVideo();
                        $this->addSchema($schema);
                    }
                }
                //todo add schema for news & google actu
            }
            $this->entries[] = $entry;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @return int
     */
    public function getMaxPerFile(): int
    {
        return $this->maxPerFile;
    }

    /**
     * @param int $maxPerFile
     * @return Sitemap
     */
    public function setMaxPerFile(int $maxPerFile): Sitemap
    {
        $this->maxPerFile = $maxPerFile;

        return $this;
    }


}