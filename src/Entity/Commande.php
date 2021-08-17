<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_total;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type_livraison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ArticleCommande::class, mappedBy="commande", orphanRemoval=true, cascade={"persist"})
     */
    private $articleCommandes;

    public function __construct()
    {
        $this->articleCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    public function getTypeLivraison(): ?string
    {
        return $this->type_livraison;
    }

    public function setTypeLivraison(string $type_livraison): self
    {
        $this->type_livraison = $type_livraison;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->Date_creation;
    }

    public function setDateCreation(\DateTimeInterface $Date_creation): self
    {
        $this->Date_creation = $Date_creation;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ArticleCommande[]
     */
    public function getArticleCommandes(): Collection
    {
        return $this->articleCommandes;
    }

    public function addArticleCommande(ArticleCommande $articleCommande): self
    {
        if (!$this->articleCommandes->contains($articleCommande)) {
            $this->articleCommandes[] = $articleCommande;
            $articleCommande->setCommande($this);
        }

        return $this;
    }

    public function removeArticleCommande(ArticleCommande $articleCommande): self
    {
        if ($this->articleCommandes->removeElement($articleCommande)) {
            // set the owning side to null (unless already changed)
            if ($articleCommande->getCommande() === $this) {
                $articleCommande->setCommande(null);
            }
        }

        return $this;
    }
}
