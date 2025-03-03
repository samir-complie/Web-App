<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[Broadcast] 
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'livraison')]
    private Collection $id_commande;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Transporteur $transporteur = null;

    public function getTransporteur(): ?Transporteur
    {
        return $this->transporteur;
    }

    public function setTransporteur(?Transporteur $transporteur): static
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $voiture = null;

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    } 

    #[ORM\Column(length: 255)]
    private ?string $etat_livraison = null;
    
    #[Assert\NotBlank(message: 'Veuillez sélectionner une date de livraison.')]  
    #[ORM\Column(type: 'datetime')]
    
    
    private ?\DateTimeInterface $date_livraison = null;

    public function __construct() 
    {
        $this->id_commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getIdCommande(): Collection
    {
        return $this->id_commande;
    }

    public function addIdCommande(Commande $idCommande): static
    {
        if (!$this->id_commande->contains($idCommande)) {
            $this->id_commande->add($idCommande);
            $idCommande->setLivraison($this);
        }

        return $this;
    }

    public function removeIdCommande(Commande $idCommande): static
    {
        if ($this->id_commande->removeElement($idCommande)) {
                if ($idCommande->getLivraison() === $this) {
                $idCommande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getEtatLivraison(): ?string
    {
        return $this->etat_livraison;
    }

    public function setEtatLivraison(string $etat_livraison): static
    {
        $this->etat_livraison = $etat_livraison;

        return $this;
    }
    
    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }
    
    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;
        return $this;
    }
} 