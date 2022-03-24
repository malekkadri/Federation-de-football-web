<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=SponsorRepository::class)
 */
class Sponsor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("sponsor")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    * @Groups("sponsor")

     */
    private $nomS;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("sponsor")

     */
    private $logoS;

    /**
     * @ORM\OneToMany(targetEntity=Club::class, mappedBy="sponsor", orphanRemoval=true)

     * @Groups("sponsor")
     */
    private $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnomS(): ?string
    {
        return $this->nomS;
    }

    public function setnomS(string $nomS): self
    {
        $this->nomS = $nomS;

        return $this;
    }

    public function getLogoS(): ?string
    {
        return $this->logoS;
    }

    public function setLogoS(?string $logoS): self
    {
        $this->logoS = $logoS;

        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
            $club->setSponsor($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->removeElement($club)) {
            // set the owning side to null (unless already changed)
            if ($club->getSponsor() === $this) {
                $club->setSponsor(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->nomS;
    }
}
