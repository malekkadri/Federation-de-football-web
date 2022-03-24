<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="The object is required")
     */
    private $objet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length (
     *     min=5,
     *     max=500,
     *     minMessage = " Description is too short ",
     *     maxMessage = " Description is too long "
     * )
     */
    private $descR;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reclamations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;




    public function getIdr(): ?int
    {
        return $this->idr;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDescR(): ?string
    {
        return $this->descR;
    }

    public function setDescR(string $descR): self
    {
        $this->descR = $descR;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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












}
