<?php

namespace App\Entity;

use App\Repository\JourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JourRepository::class)
 */
class Jour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=club::class, inversedBy="jours")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $clu;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getClu(): ?club
    {
        return $this->clu;
    }

    public function setClu(?club $clu): self
    {
        $this->clu = $clu;

        return $this;
    }

   
}
