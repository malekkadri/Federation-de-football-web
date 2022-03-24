<?php

namespace App\Entity;

use App\Repository\TournoiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TournoiRepository::class)
 */
class Tournoi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("student")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veillez remplir le champ")
     * @Assert\Length(min=3)
     * @Groups("student")

     */
    private $nomt;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     * @Groups("student")
     * @var string A "d-m-Y" formatted value
     *
     */
    private $dated;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     * @Groups("student")
     * @var string A "d-m-Y" formatted value(message="veillez entrer une date superieur a date debut")
     * @Assert\Expression(
     *     "this.getDated() < this.getDatef()")
     */
    private $datef;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Groups("student")
     */
    private $typet;

    /**
     *
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="entrer un nombre positif")
     * @Groups("student")
     */
    private $nbrc;

    /**
     * *  * @var string|null
     * @Assert\NotBlank(message="Upload your image")
     *@Groups("student")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @ORM\Column(name="logo",type="text", length=2255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="tournoi", orphanRemoval=true)
     */
    private $game;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity=Rewards::class, mappedBy="tournoi", orphanRemoval=true)
     */
    private $rewards;

    /**
     * @ORM\OneToMany(targetEntity=Classement::class, mappedBy="tournoi", orphanRemoval=true)
     */
    private $clasement;
    public function __construct()
    {
        $this->game = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomt(): ?string
    {
        return $this->nomt;
    }

    public function setNomt(string $nomt): self
    {
        $this->nomt = $nomt;

        return $this;
    }

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): self
    {
        $this->dated = $dated;

        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): self
    {

        $this->datef = $datef;

        return $this;
    }

    public function getTypet(): ?string
    {
        return $this->typet;
    }

    public function setTypet(string $typet): self
    {
        $this->typet = $typet;

        return $this;
    }

    public function getNbrc(): ?int
    {
        return $this->nbrc;
    }

    public function setNbrc(int $nbrc): self
    {
        $this->nbrc = $nbrc;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->nomt;
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
            $game->setTournoi($this);
        }

        return $this;
    }

    public function removeGame(game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTournoi() === $this) {
                $game->setTournoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rewards>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addRewards(Rewards $reward): self
    {
        if (!$this->reward->contains($reward)) {
            $this->reward[] = $reward;
            $reward->setTournoi($this);
        }

        return $this;
    }

    public function removeRewards(Rewards $reward): self
    {
        if ($this->reward->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getTournoi() === $this) {
                $reward->setTournoi(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Rewards>
     */
    public function getClasement(): Collection
    {
        return $this->clasement;
    }

    public function addClasement(Classement $clasement): self
    {
        if (!$this->clasement->contains($clasement)) {
            $this->clasement[] = $clasement;
            $clasement->setTournoi($this);
        }

        return $this;
    }

    public function removeClasement(Classement $clasement): self
    {
        if ($this->clasement->removeElement($clasement)) {
            // set the owning side to null (unless already changed)
            if ($clasement->getTournoi() === $this) {
                $clasement->setTournoi(null);
            }
        }

        return $this;
    }

}
