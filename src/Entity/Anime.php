<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
 * @ApiResource(
 *      itemOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object.getOwner() == user)"
 *          },
 *          "put"={
 *              "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object.getOwner() == user)"
 *          }
 *      },
 *      collectionOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          }
 *      }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Anime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $totalEpisode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="animes")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="anime", orphanRemoval=true)
     * @ApiSubresource()
     */
    private $episodes;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initSlug(){
       
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->title);
        
    }

     public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
        $this->initSlug();
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTotalEpisode(): ?int
    {
        return $this->totalEpisode;
    }

    public function setTotalEpisode(int $totalEpisode): self
    {
        $this->totalEpisode = $totalEpisode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setUpdatedAt(new \DateTime());
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setAnime($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getAnime() === $this) {
                $episode->setAnime(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
