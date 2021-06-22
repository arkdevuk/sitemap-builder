<?php


namespace ArkdevukSitemapBuilder\classes;


use ArkdevukSitemapBuilder\interfaces\SitemapEntryMedia;

/**
 * Class SitemapEntryVideo
 * @package ArkdevukSitemapBuilder\classes
 *
 * @see https://developers.google.com/search/docs/advanced/sitemaps/video-sitemaps?hl=fr
 */
class SitemapEntryVideo extends AbstractSitemapMedia implements SitemapEntryMedia
{
    public const TAG = 'video:video';
    /**
     * URL renvoyant au fichier image de la vignette associée à la vidéo.
     * @see https://developers.google.com/search/docs/advanced/guidelines/video?hl=fr#thumbnails
     *
     * @var string
     */
    protected string $thumbnailLoc;

    /**
     * Titre de la vidéo. Toutes les entités HTML doivent inclure un caractère d'échappement ou être encapsulées dans
     * un bloc CDATA. Il est recommandé qu'il corresponde au titre vidéo affiché sur la page Web.
     *
     * @var string
     */
    protected string $title;
    /**
     * Description de la vidéo. 2 048 caractères au maximum. Toutes les entités HTML doivent inclure un caractère
     * d'échappement ou être encapsulées dans un bloc CDATA. Elle doit correspondre à la description affichée sur
     * la page Web (sans forcément que le texte soit identique).
     *
     * @var string
     */
    protected string $description;
    /**
     * URL renvoyant au fichier vidéo multimédia. Doit correspondre à l'un des formats compatibles.
     * Les formats HTML et Flash ne sont pas acceptés.
     * Ne doit pas être identique à l'URL <loc>.
     * Il s'agit de l'équivalent de VideoObject.contentUrl dans les données structurées.
     * Bonne pratique : Si vous souhaitez restreindre l'accès à votre contenu tout en permettant son exploration,
     * assurez-vous que Googlebot a accès à votre contenu à l'aide d'une résolution DNS inverse.
     *
     * @var string|null
     */
    protected ?string $contentLoc = null;
    /**
     * URL renvoyant vers un lecteur pour une vidéo spécifique. En général, cette information est indiquée dans l'élément
     * src d'une balise <embed>.
     * Ne doit pas être identique à l'URL <loc>.
     * Pour les vidéos YouTube, cette valeur remplace video:content_loc. Il s'agit de l'équivalent de VideoObject.embedUrl
     * dans les données structurées.
     * Bonne pratique : Si vous souhaitez restreindre l'accès à votre contenu tout en permettant son exploration,
     * assurez-vous que Googlebot a accès à votre contenu à l'aide d'une résolution DNS inverse.
     * Attributs :
     * L'attribut allow_embed [facultatif] indique si Google peut intégrer la vidéo dans les résultats de recherche.
     * Les valeurs autorisées sont yes et no.
     * @var string|null
     */
    protected ?string $playerLoc = null;
    /**
     * Durée de la vidéo en secondes. Cette valeur doit être comprise entre 1 et 28800 (8 heures) inclus.
     *
     * @var int|null
     */
    protected ?int $duration = null;
    /**
     * Date à partir de laquelle la vidéo ne sera plus disponible (au format W3C). Omettez cette balise si votre vidéo n'expire pas.
     * Si elle est spécifiée, la recherche Google cessera d'afficher votre vidéo après cette date.
     * Les valeurs autorisées sont la date complète (YYYY-MM-DD) ou la date complète suivie des heures,
     * des minutes et des secondes, puis du fuseau horaire (YYYY-MM-DDThh:mm:ss+TZD).
     * Exemple : 2012-07-16T19:20:30+08:00.
     *
     * @var \DateTime|null
     */
    protected ?\DateTime $expirationDate = null;
    /**
     * Note de la vidéo. Les valeurs autorisées sont des nombres flottants compris entre 0 (minimum) et 5 (maximum) inclus.
     *
     * @var float|null
     */
    protected ?float $rating = null;
    /**
     * Nombre de fois où la vidéo a été regardée.
     *
     * @var null|int
     */
    protected ?int $viewCount = null;
    /**
     * Date à laquelle la vidéo a été publiée pour la première fois, au format W3C. Les valeurs autorisées sont la date complète (YYYY-MM-DD)
     * ou la date complète suivie des heures, des minutes et des secondes, puis du fuseau horaire (YYYY-MM-DDThh:mm:ss+TZD).
     * Exemple : 2007-07-16T19:20:30+08:00
     *
     * @var \DateTime|null
     */
    protected ?\DateTime $publicationDate = null;
    /**
     *
     * Indique si la vidéo est disponible avec SafeSearch. Si vous omettez cette balise,
     * la vidéo sera disponible lorsque SafeSearch sera activé.
     * Valeurs autorisées :
     * true : la vidéo est disponible lorsque SafeSearch est activé.
     * false : la vidéo n'est disponible que lorsque SafeSearch est désactivé.
     *
     * @var null|bool
     */
    protected ?bool $familyFriendly = null;
    /**
     * ndique si la vidéo doit être affichée ou masquée dans les résultats de recherche en fonction du type de plate-forme
     * spécifié. Les plates-formes sont indiquées sous la forme d'une liste dans laquelle elles sont séparées par un espace.
     * Notez que cette balise ne concerne que les résultats de recherche sur les types d'appareils spécifiés. Elle n'empêche
     * pas les internautes de regarder votre vidéo sur les plates-formes exclues.
     * Valeurs autorisées :

     * `web` pour désigner les navigateurs des ordinateurs de bureau et des ordinateurs portables.
     * `mobile` pour désigner les navigateurs mobiles, tels que ceux des téléphones mobiles ou des tablettes.
     * `tv` pour désigner les navigateurs de téléviseurs, tels que ceux disponibles sur les consoles de jeu ou les appareils Google TV.
     *
     * L'exemple ci-dessous permet aux utilisateurs de voir le résultat vidéo sur le Web ou sur les téléviseurs, mais pas sur les appareils mobiles :
     * <video:platform relationship="allow">web tv</video:platform>
     *
     * @var array
     */
    protected array $platformAllowed = [];
    /**
     * Indique si le visionnage de la vidéo nécessite un abonnement (payant ou non). Les valeurs autorisées sont true et false.
     *
     * @var null|bool
     */
    protected ?bool $requiresSubscription = null;
    /**
     * Nom de l'utilisateur ayant mis en ligne la vidéo. Une seule balise <video:uploader> est autorisée pour chaque vidéo.
     * La valeur de chaîne utilisée ne doit pas dépasser 255 caractères.
     *
     * @var null|string
     */
    protected ?string $uploader = null;
    /**
     * Balise de chaîne arbitraire décrivant la vidéo. Les balises sont en général de courtes descriptions des concepts
     * clés associés à une vidéo ou à une partie de contenu. Il est conseillé d'affecter plusieurs balises à une même vidéo,
     * même si celle-ci n'appartient qu'à une seule catégorie. Par exemple, une vidéo sur les grillades peut appartenir à la
     * catégorie "grillades" tout en étant associée aux balises "steak", "viande", "été" et "extérieur".
     * Créez un élément <video:tag> pour chaque balise associée à une vidéo. Un maximum de 32 balises est autorisé.
     *
     * @var null|string
     */
    protected ?string $tags = null;

    /**
     * Brève description de la catégorie générale à laquelle la vidéo appartient.
     * Il doit s'agir d'une chaîne ne dépassant pas 256 caractères. Les catégories correspondent habituellement à de larges regroupements
     * de contenu par thème. Une vidéo appartient généralement à une seule catégorie. Par exemple,
     * si un site sur la cuisine contient des catégories telles que "Grill", "Pâtisserie" et "Barbecue",
     * la vidéo peut appartenir à l'une d'elles.
     *
     * @var null|string
     */
    protected ?string $category = null;


    public function __construct()
    {
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function compile(\XMLWriter $writer): \XMLWriter
    {
        $writer->startElement(self::TAG);
        foreach ($this as $key => $value) {
            if ($value !== null) {
                switch ($key) {
                    case 'platformAllowed':
                        $writer->startElement('video:platform');
                        $writer->writeAttribute('relationship', "allow");
                        $writer->text($value);
                        $writer->endElement();
                        break;
                    case 'title':
                    case 'description':
                    case 'uploader':
                        $writer->startElement('video:'.$this->fromCamelCase($key));
                        $writer->writeCData($value);
                        $writer->endElement();
                        break;
                    case 'requiresSubscription':
                    case 'familyFriendly':
                        $value_tsl = 'yes';
                        if ($value === false) {
                            $value_tsl = 'no';
                        }
                        $writer->writeElement('video:'.$this->fromCamelCase($key), $value_tsl);
                        break;
                    case 'expirationDate':
                    case 'publicationDate':
                        $writer->writeElement(
                            'video:'
                            .$this->fromCamelCase($key),
                            $value->format(DATE_ATOM)
                        );
                    default:
                        $writer->writeElement('video:'.$this->fromCamelCase($key), $value);
                }
            }
        }
        $writer->endElement();

        return $writer;
    }

    /**
     * @param mixed $contentLoc
     * @return SitemapEntryVideo
     */
    public function setContentLoc($contentLoc)
    {
        $this->playerLoc = null;
        $this->contentLoc = $contentLoc;

        return $this;
    }

    /**
     * @param mixed $playerLoc
     * @return SitemapEntryVideo
     */
    public function setPlayerLoc($playerLoc)
    {
        $this->contentLoc = null;
        $this->playerLoc = $playerLoc;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentLoc()
    {
        return $this->contentLoc;
    }

    /**
     * @return mixed
     */
    public function getPlayerLoc()
    {
        return $this->playerLoc;
    }

    /**
     * @param string $thumbnailLoc
     * @return SitemapEntryVideo
     */
    public function setThumbnailLoc(string $thumbnailLoc): SitemapEntryVideo
    {
        $this->thumbnailLoc = $thumbnailLoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnailLoc(): string
    {
        return $this->thumbnailLoc;
    }

    /**
     * @param string $title
     * @return SitemapEntryVideo
     */
    public function setTitle(string $title): SitemapEntryVideo
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $description
     * @return SitemapEntryVideo
     */
    public function setDescription(string $description): SitemapEntryVideo
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param int|null $duration
     * @return SitemapEntryVideo
     */
    public function setDuration(?int $duration): SitemapEntryVideo
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param \DateTime|null $expirationDate
     * @return SitemapEntryVideo
     */
    public function setExpirationDate(?\DateTime $expirationDate): SitemapEntryVideo
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }

    /**
     * @param float|null $rating
     * @return SitemapEntryVideo
     */
    public function setRating(?float $rating): SitemapEntryVideo
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param int|null $viewCount
     * @return SitemapEntryVideo
     */
    public function setViewCount(?int $viewCount): SitemapEntryVideo
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    /**
     * @param \DateTime|null $publicationDate
     * @return SitemapEntryVideo
     */
    public function setPublicationDate(?\DateTime $publicationDate): SitemapEntryVideo
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublicationDate(): ?\DateTime
    {
        return $this->publicationDate;
    }

    /**
     * @param bool|null $familyFriendly
     * @return SitemapEntryVideo
     */
    public function setFamilyFriendly(?bool $familyFriendly): SitemapEntryVideo
    {
        $this->familyFriendly = $familyFriendly;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getFamilyFriendly(): ?bool
    {
        return $this->familyFriendly;
    }

    /**
     * @param array $platformAllowed
     * @return SitemapEntryVideo
     */
    public function setPlatformAllowed(array $platformAllowed): SitemapEntryVideo
    {
        $this->platformAllowed = $platformAllowed;

        return $this;
    }

    /**
     * @return array
     */
    public function getPlatformAllowed(): array
    {
        return $this->platformAllowed;
    }

    /**
     * @param bool|null $requiresSubscription
     * @return SitemapEntryVideo
     */
    public function setRequiresSubscription(?bool $requiresSubscription): SitemapEntryVideo
    {
        $this->requiresSubscription = $requiresSubscription;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getRequiresSubscription(): ?bool
    {
        return $this->requiresSubscription;
    }

    /**
     * @param string|null $uploader
     * @return SitemapEntryVideo
     */
    public function setUploader(?string $uploader): SitemapEntryVideo
    {
        $this->uploader = $uploader;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploader(): ?string
    {
        return $this->uploader;
    }

    /**
     * @param string|null $tags
     * @return SitemapEntryVideo
     */
    public function setTags(?string $tags): SitemapEntryVideo
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string|null $category
     * @return SitemapEntryVideo
     */
    public function setCategory(?string $category): SitemapEntryVideo
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }
}