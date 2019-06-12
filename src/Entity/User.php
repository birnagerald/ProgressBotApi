<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *      itemOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object == user)",
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          },
 *          "put"={
 *              "access_control"="is_granted('ROLE_ADMIN') or (is_granted('IS_AUTHENTICATED_FULLY') and object == user)",
 *              "denormalization_context"={
 *                  "groups"={"put"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          }
 *      },
 *      collectionOperations={
 *          "post"={
 *              "denormalization_context"={
 *                  "groups"={"post"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *           }
 *      },
 *      
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="Un autre utilisateur utilise déjà cette adresse mail, merci de la modifier !"
 * )
 * @UniqueEntity(
 * fields={"username"},
 * message="Un autre utilisateur utilise déjà ce pseudo, merci de le modifier !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "post", "get-admin"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Votre pseudo doit faire plus de {{ limit }} caractères",
     *      maxMessage = "Votre pseudo doit faire moins de {{ limit }} caractères"
     * )
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"post"})
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{5,}/",
     *      message="Le mot de passe doit faire plus de 5 caractères et contenir au moins 1 chiffre, 1 majuscule et 1 minuscule")
     */
    private $password;
    
    /**
     * @Assert\NotBlank()
     * @Groups({"put", "post"})
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tappé le même mot de passe !")
     */
    private $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"put", "post", "get-admin", "get-owner"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"get-admin"})
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get-admin"})
     */
    private $enable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anime", mappedBy="owner")
     * @Groups({"get"})
     */
    private $animes;

    public function __construct()
    {
        $this->enable = false;
        $this->roles = ["ROLE_USER"];
        $this->animes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
       return $this->roles;
        // // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        // return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        
    }

    /**
     * @return Collection|Anime[]
     */
    public function getAnimes(): Collection
    {
        return $this->animes;
    }

    public function addAnime(Anime $anime): self
    {
        if (!$this->animes->contains($anime)) {
            $this->animes[] = $anime;
            $anime->setOwner($this);
        }

        return $this;
    }

    public function removeAnime(Anime $anime): self
    {
        if ($this->animes->contains($anime)) {
            $this->animes->removeElement($anime);
            // set the owning side to null (unless already changed)
            if ($anime->getOwner() === $this) {
                $anime->setOwner(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
