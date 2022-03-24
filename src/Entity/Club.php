<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("club")
     */
    private $id;

    /**
     * @Groups("club")
     * @ORM\Column(type="string", length=255)
     * @Groups("club")

     */
    private $nomc;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("club")
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("club")

     */
    private $descr;

    /**
     * @ORM\OneToMany(targetEntity=Joueur::class, mappedBy="club")
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity=Sponsor::class, inversedBy="clubs")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $sponsor;

    /**
     * @ORM\OneToMany(targetEntity=Classement::class, mappedBy="club", orphanRemoval=true)
     */
    private $classements;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="club1", orphanRemoval=true)
     */
    private $games1;
/**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="club2", orphanRemoval=true)
     */
    private $games2;
    



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("club")

     */
    private $president;

    /**
     * @ORM\OneToMany(targetEntity=Jour::class, mappedBy="clu")
     */
    private $jours;

    

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->classements = new ArrayCollection();
        $this->games1 = new ArrayCollection();
        $this->games2 = new ArrayCollection();
        $this->club = new ArrayCollection();
        $this->jours = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomc(): ?string
    {
        return $this->nomc;
    }

    public function setNomc(string $nomc): self
    {
        $this->nomc = $nomc;

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

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * @return Collection|Joueur[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->setClub($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getClub() === $this) {
                $joueur->setClub(null);
            }
        }

        return $this;
    }

    public function getSponsor(): ?sponsor
    {
        return $this->sponsor;
    }

    public function setSponsor(?sponsor $sponsor): self
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * @return Collection|Classement[]
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): self
    {
        if (!$this->classements->contains($classement)) {
            $this->classements[] = $classement;
            $classement->setClub($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): self
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getClub() === $this) {
                $classement->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games1;
    }
    /**
     * @return Collection|Game[]
     */
    public function getGames2(): Collection
    {
        return $this->games2;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games1->contains($game)) {
            $this->games1[] = $game;
            $game->setClub1($this);
        }
        if (!$this->games2->contains($game)) {
            $this->games2[] = $game;
            $game->setClub2($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games1->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getClub1() === $this) {
                $game->setClub1(null);
            }
        }
        if ($this->games2->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getClub2() === $this) {
                $game->setClub2(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->nomc;
    }

    

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(string $president): self
    {
        $this->president = $president;

        return $this;
    }

    /**
     * @return Collection<int, Jour>
     */
    public function getJours(): Collection
    {
        return $this->jours;
    }

    public function addJour(Jour $jour): self
    {
        if (!$this->jours->contains($jour)) {
            $this->jours[] = $jour;
            $jour->setClu($this);
        }

        return $this;
    }

    public function removeJour(Jour $jour): self
    {
        if ($this->jours->removeElement($jour)) {
            // set the owning side to null (unless already changed)
            if ($jour->getClu() === $this) {
                $jour->setClu(null);
            }
        }

        return $this;
    }


}
