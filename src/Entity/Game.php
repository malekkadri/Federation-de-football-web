<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message = "remplissez le champ du score de l'equipe 1 SVP"
     * )
     * * @Assert\GreaterThan  (
     *     value = -0.9,
     *     message = "Le score ne doit pas etre negative"
     * )
     * @Assert\LessThan(
     *     value = 25,
     *     message = "Le Score ne doit pas dépasser 25 "
     * )
     * @Groups("stade:read")
     */
    private $r1;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message = "remplissez le champ du score de l'equipe 2 SVP"
     * )
     * @Assert\GreaterThan  (
     *     value = -0.9,
     *     message = "Le score ne doit pas etre negative"
     * )
     * @Assert\LessThan(
     *     value = 25,
     *     message = "Le Score ne doit pas dépasser 25 "
     * )
     * @Groups("stade:read")
     */
    private $r2;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     * @Assert\DateTime
     * @Assert\LessThanOrEqual(
     *     value = "today UTC",
     *     message = "le date doit étre avant la date d'aujourd'hui "
     * )
     * @Assert\NotBlank(
     * message = "remplissez le champ SVP"
     * )
     */
    private $dated;



    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club1;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club2;

    /**
     * @ORM\ManyToOne(targetEntity=Arbitre::class, inversedBy="game")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $arbitre;

    /**
     * @ORM\ManyToOne(targetEntity=Stade::class, inversedBy="game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stade;

    /**
     * @ORM\ManyToOne(targetEntity=Tournoi::class, inversedBy="game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournoi;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getR1(): ?int
    {
        return $this->r1;
    }

    public function setR1(int $r1): self
    {
        $this->r1 = $r1;

        return $this;
    }

    public function getR2(): ?int
    {
        return $this->r2;
    }

    public function setR2(int $r2): self
    {
        $this->r2 = $r2;

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

    public function getClub1(): ?club
    {
        return $this->club1;
    }

    public function setClub1(?club $club1): self
    {
        $this->club1 = $club1;

        return $this;
    }

    public function getClub2(): ?club
    {
        return $this->club2;
    }

    public function setClub2(?club $club2): self
    {
        $this->club2 = $club2;

        return $this;
    }

    public function getArbitre(): ?Arbitre
    {
        return $this->arbitre;
    }

    public function setArbitre(?Arbitre $arbitre): self
    {
        $this->arbitre = $arbitre;

        return $this;
    }

    public function getStade(): ?Stade
    {
        return $this->stade;
    }

    public function setStade(?Stade $stade): self
    {
        $this->stade = $stade;

        return $this;
    }
    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

        return $this;
    }


}
