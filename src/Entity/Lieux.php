<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LieuxRepository::class)]
class Lieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(
        message: 'Un nom de lieu doit être renseigné'
    )]
    #[Assert\length(
        min: 4,
        max: 30,
        minMessage: '4 caractères minimum',
        maxMessage: '30 caractères maximum',
    )]
    #[Assert\Regex(
        pattern: '/^([^0-9]*)$/',
        match: true,
        message: 'Le nom de la sortie ne peux contenir de nombre',
    )]
    private ?string $nom_lieu = null;

    #[ORM\Column(length: 30, nullable: false)]
    #[Assert\NotBlank(
        message: 'Une rue doit être renseignée'
    )]
    #[Assert\Length(
        min: 10,
        max: 30,
        minMessage: "Le nom ne peut être inférieur a {{ min }} caractères.",
        maxMessage: "Le pseudo ne peut pas être supérieur à {{ max }} caractères."
    )]

    private ?string $rue = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: '^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$',
        match: true,
        message: 'Cela ne ressemble pas à une latitude',
    )]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: '^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$',
        match: true,
        message: 'Cela ne ressemble pas à une longitude',
    )]
    private ?float $longitude = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Villes $villes_no_ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): self
    {
        $this->nom_lieu = $nom_lieu;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVillesNoVille(): ?Villes
    {
        return $this->villes_no_ville;
    }

    public function setVillesNoVille(?Villes $villes_no_ville): self
    {
        $this->villes_no_ville = $villes_no_ville;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() . '|' . $this->getRue() . '|' . $this->getLongitude() . '|' . $this->getLatitude() . '|' . $this->getVillesNoVille()->getNomVille() . '|' . $this->getVillesNoVille()->getCodePostal();
    }
}
