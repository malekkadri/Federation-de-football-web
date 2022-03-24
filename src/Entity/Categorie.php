<?php

namespace App\Entity;

use App\Repository\CathegorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CathegorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("cat")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotEqualTo("")
     * @Groups("cat")
     */

    private $typeC;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeC(): ?string
    {
        return $this->typeC;
    }

    public function setTypeC(string $typeC): self
    {
        $this->typeC = $typeC;

        return $this;
    }

    /**
     * @return Collection|produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setCategorie($this);
        }

        return $this;
    }

    public function removeProduit(produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }


}
