<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(fields: ['pseudo'], message: 'Ce pseudo est déja prit')]
class Participants implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Le pseudo doit être supérieur à 2 caractères.",
        maxMessage: "Le pseudo ne peut pas être supérieur à 20 caractères."
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 20, unique: true)]
    private ?string $pseudo = null;
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]/',
        message: 'Le nom ne peut contenir que des lettres',
        match: false,
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[Assert\Regex(
        pattern: '/^[a-zA-Z]/',
        message: 'Le prenom ne peut contenir que des lettres',
        match: false,
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[Assert\Regex(
        pattern: '/^[0-9]/',
        message: 'Le numéro de téléphone ne doit contenir que des chiffres',
        match: false,
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone = null;

    #[Assert\Email]
    #[Assert\NotBlank]
    #[ORM\Column(length: 20)]
    private ?string $mail = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 20,
        minMessage: "Mot de passe trop court.",
        maxMessage: "Mot de passe trop long."
    )]
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sites $sites_no_site = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $image;
    /**
     * @Vich\UploadableField(mapping="products", fileNameProperty="image")
     */
    private ?File $imageFile;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\Column(nullable: true)]
    private ?bool $administrateur = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    public function getSitesNoSite(): ?Sites
    {
        return $this->sites_no_site;
    }

    public function setSitesNoSite(?Sites $sites_no_site): self
    {
        $this->sites_no_site = $sites_no_site;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image){
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function isAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(?bool $administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }
}
