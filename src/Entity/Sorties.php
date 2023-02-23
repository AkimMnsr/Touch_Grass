<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortiesRepository::class)]
class Sorties
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\Regex(
        pattern: '/^([^0-9]*)$/',
        match: true,
        message: 'Le nom de la sortie ne peux contenir de nombre',
    )]
    #[Assert\NotBlank(
        message: 'Un nom de sortie doit être renseigné'
    )]
    #[Assert\Length(
        min: 4,
        max: 30,
        minMessage: "Le nom ne peut être inférieur a 4 caractères.",
        maxMessage: "Le pseudo ne peut pas être supérieur à 30 caractères."
    )]
    private ?string $nom = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThanOrEqual ('today',
        message: 'La date de sortie ne peux être inférieur à la date du jour'
    )]
    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(nullable: false)]
    #[Assert\Type(type: "integer")]
    #[Assert\Range(
        min: 15,
        max: 480,
        notInRangeMessage: 'La durée doit être comprise entre {{ min }} minutes et {{ max }} minutes',

    )]
    #[Assert\NotBlank(message: "Vous devez renseigner une durée")]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\LessThanOrEqual (
        propertyPath: "datedebut",
        message: 'La date de limite d\'nscription ne peux être supérieure à la date de sortie'
    )]
    #[Assert\GreaterThanOrEqual ('today',
        message: 'La date de sortie ne peux être inférieur à la date du jour'
    )]
    private ?\DateTimeInterface $datecloture = null;

    #[ORM\Column (nullable: false)]
    #[Assert\Type(type: "integer")]
    #[Assert\NotBlank(message: "Vous devez renseigner le nombre de place")]
    #[Assert\Range(
        min: 2,
        max: 100,
        notInRangeMessage: 'Le nombre de place doit être compris entre {{ min }} et {{ max }}',
    )]
    private ?int $nbinscriptionsmax = null;

    #[ORM\Column(length: 500, nullable: false)]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: 'La description doit être au minimum de 10 caractères',
        maxMessage: 'La description doit être au maximum de 500 caractères',
    )]
    private ?string $descriptioninfos = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $urlPhoto = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieux $lieux_no_lieu = null;

    #[ORM\Column(nullable: true)]
    private ?int $etatsortie = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participants $organisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etats $etats_no_etat = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?Inscriptions $id_inscription = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDatecloture(): ?\DateTimeInterface
    {
        return $this->datecloture;
    }

    public function setDatecloture(\DateTimeInterface $datecloture): self
    {
        $this->datecloture = $datecloture;

        return $this;
    }

    public function getNbinscriptionsmax(): ?int
    {
        return $this->nbinscriptionsmax;
    }

    public function setNbinscriptionsmax(int $nbinscriptionsmax): self
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;

        return $this;
    }

    public function getDescriptioninfos(): ?string
    {
        return $this->descriptioninfos;
    }

    public function setDescriptioninfos(?string $descriptioninfos): self
    {
        $this->descriptioninfos = $descriptioninfos;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    public function getLieuxNoLieu(): ?Lieux
    {
        return $this->lieux_no_lieu;
    }

    public function setLieuxNoLieu(?Lieux $lieux_no_lieu): self
    {
        $this->lieux_no_lieu = $lieux_no_lieu;

        return $this;
    }

    public function getEtatsortie(): ?int
    {
        return $this->etatsortie;
    }

    public function setEtatsortie(?int $etatsortie): self
    {
        $this->etatsortie = $etatsortie;

        return $this;
    }

    public function getOrganisateur(): ?Participants
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participants $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getEtatsNoEtat(): ?Etats
    {
        return $this->etats_no_etat;
    }

    public function setEtatsNoEtat(?Etats $etats_no_etat): self
    {
        $this->etats_no_etat = $etats_no_etat;

        return $this;
    }

    public function getIdInscription(): ?Inscriptions
    {
        return $this->id_inscription;
    }

    public function setIdInscription(?Inscriptions $id_inscription): self
    {
        $this->id_inscription = $id_inscription;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

}
