<?php

namespace App\Entity;

use App\Repository\InteractionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InteractionRepository::class)
 */
class Interaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descrp;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Interactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="Interaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;



    public function getIdi(): ?int
    {
        return $this->idi;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescrp(): ?string
    {
        return $this->descrp;
    }

    public function setDescrp(?string $descrp): self
    {
        $this->descrp = $descrp;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

}
