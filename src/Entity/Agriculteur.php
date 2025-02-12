<?php

namespace App\Entity;

use App\Repository\AgriculteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AgriculteurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Agriculteur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $RIB = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?float $payment = null;

    /**
     * @var Collection<int, ProduitStore>
     */
    #[ORM\OneToMany(targetEntity: ProduitStore::class, mappedBy: 'agriculteur_id')]
    private Collection $produitStores;

    /**
     * @var Collection<int, ProduitEnchere>
     */
    #[ORM\OneToMany(targetEntity: ProduitEnchere::class, mappedBy: 'agriculteur_id')]
    private Collection $produitEncheres;

    /**
     * @var Collection<int, Enchere>
     */
    #[ORM\OneToMany(targetEntity: Enchere::class, mappedBy: 'id_agriculteur')]
    private Collection $encheres;

    public function __construct()
    {
        $this->produitStores = new ArrayCollection();
        $this->produitEncheres = new ArrayCollection();
        $this->encheres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRIB(): ?int
    {
        return $this->RIB;
    }

    public function setRIB(int $RIB): static
    {
        $this->RIB = $RIB;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPayment(): ?float
    {
        return $this->payment;
    }

    public function setPayment(float $payment): static
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return Collection<int, ProduitStore>
     */
    public function getProduitStores(): Collection
    {
        return $this->produitStores;
    }

    public function addProduitStore(ProduitStore $produitStore): static
    {
        if (!$this->produitStores->contains($produitStore)) {
            $this->produitStores->add($produitStore);
            $produitStore->setAgriculteurId($this);
        }

        return $this;
    }

    public function removeProduitStore(ProduitStore $produitStore): static
    {
        if ($this->produitStores->removeElement($produitStore)) {
            // set the owning side to null (unless already changed)
            if ($produitStore->getAgriculteurId() === $this) {
                $produitStore->setAgriculteurId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProduitEnchere>
     */
    public function getProduitEncheres(): Collection
    {
        return $this->produitEncheres;
    }

    public function addProduitEnchere(ProduitEnchere $produitEnchere): static
    {
        if (!$this->produitEncheres->contains($produitEnchere)) {
            $this->produitEncheres->add($produitEnchere);
            $produitEnchere->setAgriculteurId($this);
        }

        return $this;
    }

    public function removeProduitEnchere(ProduitEnchere $produitEnchere): static
    {
        if ($this->produitEncheres->removeElement($produitEnchere)) {
            // set the owning side to null (unless already changed)
            if ($produitEnchere->getAgriculteurId() === $this) {
                $produitEnchere->setAgriculteurId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enchere>
     */
    public function getEncheres(): Collection
    {
        return $this->encheres;
    }

    public function addEnchere(Enchere $enchere): static
    {
        if (!$this->encheres->contains($enchere)) {
            $this->encheres->add($enchere);
            $enchere->setIdAgriculteur($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): static
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getIdAgriculteur() === $this) {
                $enchere->setIdAgriculteur(null);
            }
        }

        return $this;
    }
}
