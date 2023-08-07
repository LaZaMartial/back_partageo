<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FactureRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Serializer\PatchedDateTimeNormalizer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
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
        "groups" => ["facture_read"]
    ]
)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["facture_read", "adresse_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["facture_read", "adresse_read"])]
    private ?string $Ref_facture = null;

    #[ORM\Column]
    #[Groups(["facture_read", "adresse_read"])]
    private ?int $Montant_electricite = null;

    #[ORM\Column]
    #[Groups(["facture_read", "adresse_read"])]
    private ?int $Montant_eau = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["facture_read", "adresse_read"])]
    #[Context([PatchedDateTimeNormalizer::FORMAT_KEY => 'd-m-Y'])]
    private ?\DateTimeInterface $Date = null;

    #[ORM\OneToOne(inversedBy: 'Facture', cascade: ['persist', 'remove'])]
    #[Groups(["facture_read"])]
    private ?Adresse $Adresse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefFacture(): ?string
    {
        return $this->Ref_facture;
    }

    public function setRefFacture(string $Ref_facture): static
    {
        $this->Ref_facture = $Ref_facture;

        return $this;
    }

    public function getMontantElectricite(): ?int
    {
        return $this->Montant_electricite;
    }

    public function setMontantElectricite(int $Montant_electricite): static
    {
        $this->Montant_electricite = $Montant_electricite;

        return $this;
    }

    public function getMontantEau(): ?int
    {
        return $this->Montant_eau;
    }

    public function setMontantEau(int $Montant_eau): static
    {
        $this->Montant_eau = $Montant_eau;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
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
}
