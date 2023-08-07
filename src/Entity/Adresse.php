<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdresseRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
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
        "groups" => ["adresse_read"]
    ],
)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["adresse_read", "facture_read", "utilisateur_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["adresse_read", "facture_read", "utilisateur_read"])]
    private ?string $Nom_adresse = null;

    #[ORM\OneToMany(mappedBy: 'Adresse', targetEntity: Utilisateur::class)]
    #[Groups(["adresse_read"])]
    private Collection $Utilisateur;

    #[ORM\OneToOne(mappedBy: 'Adresse', cascade: ['persist', 'remove'])]
    #[Groups(["adresse_read"])]
    private ?Facture $Facture = null;

    public function __construct()
    {
        $this->Utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAdresse(): ?string
    {
        return $this->Nom_adresse;
    }

    public function setNomAdresse(string $Nom_adresse): static
    {
        $this->Nom_adresse = $Nom_adresse;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->Utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->Utilisateur->contains($utilisateur)) {
            $this->Utilisateur->add($utilisateur);
            $utilisateur->setAdresse($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->Utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getAdresse() === $this) {
                $utilisateur->setAdresse(null);
            }
        }

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->Facture;
    }

    public function setFacture(?Facture $Facture): static
    {
        // unset the owning side of the relation if necessary
        if ($Facture === null && $this->Facture !== null) {
            $this->Facture->setAdresse(null);
        }

        // set the owning side of the relation if necessary
        if ($Facture !== null && $Facture->getAdresse() !== $this) {
            $Facture->setAdresse($this);
        }

        $this->Facture = $Facture;

        return $this;
    }
}
