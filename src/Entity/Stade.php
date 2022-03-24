<?php

namespace App\Entity;

use App\Repository\StadeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StadeRepository::class)
 */
class Stade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("stade : read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "l'adresse doit comporter au moins  {{ limit }} caractères")
     * 
     * @Assert\NotBlank(message="l'adresse de terrain est obligatoire")
     * @Groups("stade : read")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "le nom du terrain doit comporter au moins  {{ limit }} caractères")
     * @Assert\NotBlank(message="le nom de terrain est obligatoire")
     * @Groups("stade : read")
     */
    private $noms;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("stade : read")

     */
    private $etat;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message = "remplissez le champ SVP"
     * )
     * @Assert\GreaterThan  (
     *     value = 100,
     *     message = "Le nombre Maximun de capciter doit dépasser 100 "
     * )
     * @Assert\LessThan(
     *     value = 150000,
     *     message = "Le nombre Maximun de capciter ne doit pas dépasser 100000 "
     * )
     * @Groups("stade : read")
     */

    private $nbrP;

    /**
     *  * @var string|null
     *
     * @ORM\Column(name="photo", type="text", length=65535, nullable=true)
     * @Assert\NotBlank(message="Upload your image")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @Groups("stade : read")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="stade", orphanRemoval=true)
     */
    private $game;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNbrP(): ?int
    {
        return $this->nbrP;
    }

    public function setNbrP(int $nbrP): self
    {
        $this->nbrP = $nbrP;

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
            $game->setStade($this);
        }

        return $this;
    }

    public function removeGame(game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getStade() === $this) {
                $game->setStade(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->noms;
    }

}
