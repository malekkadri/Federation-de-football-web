<?php

namespace App\Entity;

use App\Repository\BadgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BadgeRepository::class)
 */
class Badge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("badge")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("badge")
     * @Assert\NotBlank(message="Badge Name is required")
     * @Assert\Length(
     *      min = 5,
     *      max = 25,
     *      minMessage = "Your BadgeName  must be at least {{ limit }} characters long",
     *      maxMessage = "Your BadgeName  cannot be longer than {{ limit }} characters"
     * )
     */
    private $nomB;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("badge")
     * @Assert\NotBlank(message = " Please upload image")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $logoB;

    /**
     * @ORM\Column(type="integer")
     * @Groups("badge")
     */
    private $nb;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="badge")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomB(): ?string
    {
        return $this->nomB;
    }

    public function setNomB(string $nomB): self
    {
        $this->nomB = $nomB;

        return $this;
    }

    public function getLogoB(): ?string
    {
        return $this->logoB;
    }

    public function setLogoB(string $logoB): self
    {
        $this->logoB = $logoB;

        return $this;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setBadge($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getBadge() === $this) {
                $user->setBadge(null);
            }
        }

        return $this;
    }

}
