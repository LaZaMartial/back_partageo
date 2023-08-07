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
use App\Repository\UtiliserMaterielRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtiliserMaterielRepository::class)]
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
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new Delete(
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        ),
        new Put(
            security: "is_granted('ROLE_USER')",
            securityMessage: "Seul l'utilisateur peuvent avoir accès à ces informations."
        )
    ],    
    normalizationContext: [
        "groups" => ["utiliser_read"]
    ]
)]
class UtiliserMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["utiliser_read", "utilisateur_read", "materiel_read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["utiliser_read", "utilisateur_read", "materiel_read"])]
    private ?int $Duree_utilisation = null;

    #[ORM\ManyToOne(inversedBy: 'Materiel')]
    #[Groups(["utiliser_read", "materiel_read"])]
    private ?Utilisateur $Utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'Utilisateur')]
    #[Groups(["utiliser_read", "utilisateur_read"])]
    private ?Materiel $Materiel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDureeUtilisation(): ?int
    {
        return $this->Duree_utilisation;
    }

    public function setDureeUtilisation(int $Duree_utilisation): static
    {
        $this->Duree_utilisation = $Duree_utilisation;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): static
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->Materiel;
    }

    public function setMateriel(?Materiel $Materiel): static
    {
        $this->Materiel = $Materiel;

        return $this;
    }
}
