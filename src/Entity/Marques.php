<?php

namespace App\Entity;

use App\Repository\MarquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MarquesRepository::class)
 */
class Marques
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("marque")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotEqualTo("")
     * @Groups("marque")
     */
    private $nomM;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="marquep")
     */
    private $marque_p;





    public function __construct()
    {
        $this->marque_produit = new ArrayCollection();
        $this->marqueP = new ArrayCollection();
        $this->marque_p = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomM(): ?string
    {
        return $this->nomM;
    }

    public function setNomM(string $nomM): self
    {
        $this->nomM = $nomM;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getMarqueP(): Collection
    {
        return $this->marque_p;
    }

    public function addMarqueP(Produit $marqueP): self
    {
        if (!$this->marque_p->contains($marqueP)) {
            $this->marque_p[] = $marqueP;
            $marqueP->setMarquep($this);
        }

        return $this;
    }

    public function removeMarqueP(Produit $marqueP): self
    {
        if ($this->marque_p->removeElement($marqueP)) {
            // set the owning side to null (unless already changed)
            if ($marqueP->getMarquep() === $this) {
                $marqueP->setMarquep(null);
            }
        }

        return $this;
    }














}
