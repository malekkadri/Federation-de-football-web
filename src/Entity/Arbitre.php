<?php

namespace App\Entity;

use App\Repository\ArbitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArbitreRepository::class)
 */
class Arbitre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post : read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "le nom d'arbitre doit comporter au moins  {{ limit }} caractères")
     * @Assert\NotBlank(message="le nom de terrain est obligatoire")
     * @Groups("post : read")
     */
    private $nomA;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message = "remplissez le champ SVP"
     * )
     * @Assert\GreaterThan  (
     *     value = 1,
     *     message = "Le nombre d'experience doit dépasser 1 ans"
     * )
     * @Assert\LessThan(
     *     value = 25,
     *     message = "Le nombre d'experience ne doit pas dépasser 25 ans"
     * )
     * @Groups("post : read")
     */
    private $nbe;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="arbitre", orphanRemoval=true)
     */
    private $game;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Upload your image")
     * @Groups("post : read")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(
     *      min = 10,
     *      minMessage = "le description doit comporter au moins  {{ limit }} caractères")
     * @Assert\NotBlank(message="le description est obligatoire")
     * @Groups("post : read")
     */
    private $descrp;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomA(): ?string
    {
        return $this->nomA;
    }

    public function setNomA(string $nomA): self
    {
        $this->nomA = $nomA;

        return $this;
    }

    public function getNbe(): ?int
    {
        return $this->nbe;
    }

    public function setNbe(int $nbe): self
    {
        $this->nbe = $nbe;

        return $this;
    }

    /**
     * @return Collection|game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setArbitre($this);
        }

        return $this;
    }

    public function removeGame(game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getArbitre() === $this) {
                $game->setArbitre(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescrp(): ?string
    {
        return $this->descrp;
    }

    public function setDescrp(string $descrp): self
    {
        $this->descrp = $descrp;

        return $this;
    }
    public function __toString() {
        return $this->nomA;
    }
}
