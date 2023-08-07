<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Repository\UtilisateurRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new GetCollection(
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new Post(
            processor: UserPasswordHasher::class,
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new Delete(
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new Put(
            processor: UserPasswordHasher::class,
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        )
    ],     
    normalizationContext: [
        "groups" => ["utilisateur_read"]
    ]
)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["utilisateur_read", "materiel_read", "utiliser_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["utilisateur_read", "materiel_read", "utiliser_read"])]
    private ?string $Nom = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'Utilisateur')]
    #[Groups(["utilisateur_read"])]
    private ?Adresse $Adresse = null;

    #[ORM\OneToMany(mappedBy: 'Utilisateur', targetEntity: UtiliserMateriel::class)]
    #[Groups(["utilisateur_read"])]
    private Collection $Materiel;

    public function __construct()
    {
        $this->Materiel = new ArrayCollection();
    }

    #[Groups(["utilisateur_read"])]
    public function getMontantElectricite(): int {
        return array_reduce($this->Materiel->toArray(), function($total, $mat){
            return $total + (($mat->getDureeUtilisation() * $mat->getMateriel()->getNombreKw()) * 150);
        }, 0);
    }

    // public function getNombreUtilisateur(): int {       
    //     $total = 0;
    //     foreach($this->getAdresse()->getUtilisateur()->toArray() as $utilisateur){
    //         return $total++;
    //     }
    //     return $total;
    // }

    // #[Groups(["utilisateur_read"])]
    // public function getMontantEau(): int {
    //     return $this->getAdresse()->getFacture()->getMontantEau() / $this->getNombreUtilisateur();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Nom;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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

    public function getAdresse(): ?Adresse
    {
        return $this->Adresse;
    }

    public function setAdresse(?Adresse $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection<int, UtiliserMateriel>
     */
    public function getMateriel(): Collection
    {
        return $this->Materiel;
    }

    public function addMateriel(UtiliserMateriel $materiel): static
    {
        if (!$this->Materiel->contains($materiel)) {
            $this->Materiel->add($materiel);
            $materiel->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMateriel(UtiliserMateriel $materiel): static
    {
        if ($this->Materiel->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getUtilisateur() === $this) {
                $materiel->setUtilisateur(null);
            }
        }

        return $this;
    }
}
