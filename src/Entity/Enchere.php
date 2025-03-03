<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: EnchereRepository::class)]

class Enchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $derniere_prix = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $id_gagnant = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agriculteur $id_agriculteur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProduitEnchere $id_Produit_enchere = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDernierePrix(): ?float
    {
        return $this->derniere_prix;
    }

    public function setDernierePrix(float $derniere_prix): static
    {
        $this->derniere_prix = $derniere_prix;

        return $this;
    }

    public function getIdGagnant(): ?Users
    {
        return $this->id_gagnant;
    }

    public function setIdGagnant(?Users $id_gagnant): static
    {
        $this->id_gagnant = $id_gagnant;

        return $this;
    }

    public function getIdAgriculteur(): ?Agriculteur
    {
        return $this->id_agriculteur;
    }

    public function setIdAgriculteur(?Agriculteur $id_agriculteur): static
    {
        $this->id_agriculteur = $id_agriculteur;

        return $this;
    }

    public function getIdProduitEnchere(): ?ProduitEnchere
    {
        return $this->id_Produit_enchere;
    }

    public function setIdProduitEnchere(ProduitEnchere $id_Produit_enchere): static
    {
        $this->id_Produit_enchere = $id_Produit_enchere;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
