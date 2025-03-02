<?php

namespace App\Entity;

use App\Repository\ProduitEnchereRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ProduitEnchereRepository::class)]

class ProduitEnchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomP = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantie = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $prixF = null;
    
    private ?float $prixI = null;

    #[ORM\Column(length: 255)]
    private ?string $path_img = null;

    #[ORM\ManyToOne(inversedBy: 'produitEncheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agriculteur $agriculteur = null;

    #[ORM\ManyToOne(inversedBy: 'produitEncheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): static
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantie(): ?int
    {
        return $this->quantie;
    }

    public function setQuantie(int $quantie): static
    {
        $this->quantie = $quantie;

        return $this;
    }

    public function getPrixF(): ?int
    {
        return $this->quantie;
    }

    public function setPrixF(int $quantie): static
    {
        $this->quantie = $quantie;

        return $this;
    }
    public function getprixI(): ?int
    {
        return $this->quantie;
    }

    public function setprixI(int $quantie): static
    {
        $this->quantie = $quantie;

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->path_img;
    }

    public function setPathImg(string $path_img): static
    {
        $this->path_img = $path_img;

        return $this;
    }

    public function getAgriculteur(): ?Agriculteur
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?Agriculteur $agriculteur): static
    {
        $this->agriculteur = $agriculteur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
