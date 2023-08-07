<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaterielRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
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
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul l'administrateur peuvent avoir accès à ces informations."
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul l'administrateur peuvent avoir accès à ces informations."
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul l'administrateur peuvent avoir accès à ces informations."
        )
    ],
    normalizationContext: [
        "groups" => ["materiel_read"]
    ]
)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["materiel_read", "utilisateur_read", "utiliser_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["materiel_read", "utilisateur_read", "utiliser_read"])]
    private ?string $Nom_materiel = null;

    #[ORM\Column]
    #[Groups(["materiel_read", "utilisateur_read", "utiliser_read"])]
    private ?int $Nombre_kw = null;

    #[ORM\OneToMany(mappedBy: 'Materiel', targetEntity: UtiliserMateriel::class)]
    #[Groups(["materiel_read"])]
    private Collection $Utilisateur;

    public function __construct()
    {
        $this->Utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMateriel(): ?string
    {
        return $this->Nom_materiel;
    }

    public function setNomMateriel(string $Nom_materiel): static
    {
        $this->Nom_materiel = $Nom_materiel;

        return $this;
    }

    public function getNombreKw(): ?int
    {
        return $this->Nombre_kw;
    }

    public function setNombreKw(int $Nombre_kw): static
    {
        $this->Nombre_kw = $Nombre_kw;

        return $this;
    }

    /**
     * @return Collection<int, UtiliserMateriel>
     */
    public function getUtilisateur(): Collection
    {
        return $this->Utilisateur;
    }

    public function addUtilisateur(UtiliserMateriel $utilisateur): static
    {
        if (!$this->Utilisateur->contains($utilisateur)) {
            $this->Utilisateur->add($utilisateur);
            $utilisateur->setMateriel($this);
        }

        return $this;
    }

    public function removeUtilisateur(UtiliserMateriel $utilisateur): static
    {
        if ($this->Utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getMateriel() === $this) {
                $utilisateur->setMateriel(null);
            }
        }

        return $this;
    }
}
