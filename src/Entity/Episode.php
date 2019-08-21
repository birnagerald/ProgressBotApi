<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      attributes={
 *         "order"={"number": "ASC"},
 *         "pagination_client_enabled"=true,
 *         "pagination_client_items_per_page"=true
 *      },
 *      itemOperations={
 *          "get"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user"
 *          },
 *          "put"={
 *              "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object.getOwner() == user)"
 *          },
 *          "delete"={
 *             "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object.getOwner() == user)"
 *         }
 *      },
 *      collectionOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          }
 *      },
 *      denormalizationContext={
 *          "groups"={"post"}
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EpisodeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Episode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post"})
     */
    private $number;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $translation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $time;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $proofreading;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $edition;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $qualityCheck;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $encoding;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $typeset;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post"})
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Anime", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post"})
     */
    private $anime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getTranslation(): ?bool
    {
        return $this->translation;
    }

    public function setTranslation(bool $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getTime(): ?bool
    {
        return $this->time;
    }

    public function setTime(bool $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getProofreading(): ?bool
    {
        return $this->proofreading;
    }

    public function setProofreading(bool $proofreading): self
    {
        $this->proofreading = $proofreading;

        return $this;
    }

    public function getEdition(): ?bool
    {
        return $this->edition;
    }

    public function setEdition(bool $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    public function getQualityCheck(): ?bool
    {
        return $this->qualityCheck;
    }

    public function setQualityCheck(bool $qualityCheck): self
    {
        $this->qualityCheck = $qualityCheck;

        return $this;
    }

    public function getEncoding(): ?bool
    {
        return $this->encoding;
    }

    public function setEncoding(bool $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function getTypeset(): ?bool
    {
        return $this->typeset;
    }

    public function setTypeset(bool $typeset): self
    {
        $this->typeset = $typeset;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(?Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }
    
    public function __toString()
    {
        return (string) $this->getNumber();
    }
}
