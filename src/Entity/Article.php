<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
     * @Assert\NotBlank(message="title is required")
     * @Groups("student")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Your title name must be at least {{ limit }} characters long",
     *      maxMessage = "Your title name cannot be longer than {{ limit }} characters"
     * )
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Description is required")
     * @Groups("student")
     * @Assert\Length(
     *      min = 10,
     *      max = 254,
     *      minMessage = "Your Description  must be at least {{ limit }} characters long",
     *      maxMessage = "Your Description  cannot be longer than {{ limit }} characters"
     * )
     */
    private $descr;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message = " Please add a date")
     * @Groups("student")
     * @Assert\Date
     *
     * @var string A "Y-m-d" formatted value
     */
    private $datea;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = " Please upload image")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @Groups("student")
     */
    private $img;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Interaction::class, mappedBy="article", orphanRemoval=true)
     */
    private $interaction;



    public function __construct()
    {
        $this->interaction = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDatea(): ?\DateTimeInterface
    {
        return $this->datea;
    }

    public function setDatea(\DateTimeInterface $datea): self
    {
        $this->datea = $datea;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg( $img)
    {
        $this->img = $img;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|interaction[]
     */
    public function getInteraction(): Collection
    {
        return $this->interaction;
    }

    public function addInteraction(interaction $interaction): self
    {
        if (!$this->interaction->contains($interaction)) {
            $this->interaction[] = $interaction;
            $interaction->setArticle($this);
        }

        return $this;
    }

    public function removeInteraction(interaction $interaction): self
    {
        if ($this->interaction->removeElement($interaction)) {
            // set the owning side to null (unless already changed)
            if ($interaction->getArticle() === $this) {
                $interaction->setArticle(null);
            }
        }

        return $this;
    }

}
