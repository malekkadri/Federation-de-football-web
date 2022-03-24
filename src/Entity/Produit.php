<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("prod")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Groups("prod")
     */
    private $nomP;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Groups("prod")
     */
    private $taille;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotEqualTo("")
     * @Groups("prod")
     */
    private $couleur;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull
     * @ASSERT\Positive
     * @Groups("prod")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     * @Groups("prod")
     */
    private $descr;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @ASSERT\Positive
     * @Groups("prod")
     */
    private $qte;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("prod")
     */
    private $img;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produit")
     * @ORM\JoinColumn(nullable=false)
     * @Groups ("prod")
     */
    private $categorie;





    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("prod")
     */
    private $taille2;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("prod")
     */
    private $date_ajout;

    /**
     * @ORM\ManyToOne(targetEntity=Marques::class, inversedBy="marque_p")
     * @Groups("prod")
     */
    private $marquep;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="produit")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): self
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(?string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


    public function getTaille2(): ?string
    {
        return $this->taille2;
    }

    public function setTaille2(string $taille2): self
    {
        $this->taille2 = $taille2;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(?\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout =$date_ajout;

        return $this;
    }

    public function getMarquep(): ?Marques
    {
        return $this->marquep;
    }

    public function setMarquep(?Marques $marquep): self
    {
        $this->marquep = $marquep;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }












}
