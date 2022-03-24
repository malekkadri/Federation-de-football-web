<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=JoueurRepository::class)
 */
class Joueur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("joueur")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("joueur")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")

     */
    private $age;
    

    /**
     * @ORM\Column(type="integer")

     */
    private $nbm;

    /**
     * @ORM\Column(type="integer")

     */
     private $nba;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="joueurs")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")

     */
    private $club;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("joueur")
     */
    private $poste;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $nationalite;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $photo;

    /**
     * @ORM\Column(type="integer")

     */
    private $numt;

    public function getCin(): ?int
    {
        return $this->cin;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNbm(): ?int
    {
        return $this->nbm;
    }

    public function setNbm(int $nbm): self
    {
        $this->nbm = $nbm;

        return $this;
    }

    public function getNba(): ?int
    {
        return $this->nba;
    }

    public function setNba(int $nba): self
    {
        $this->nba = $nba;

        return $this;
    }

    public function getClub(): ?club
    {
        return $this->club;
    }

    public function setClub(?club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNumt(): ?int
    {
        return $this->numt;
    }

    public function setNumt(int $numt): self
    {
        $this->numt = $numt;

        return $this;
    }
}
