<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
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
    #[ORM\Column(length: 20, unique: true)]
    private ?string $pseudo = null;

    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Le nom doit être supérieur à 2 caractères.",
        maxMessage: "Le nom ne peut pas être supérieur à 20 caractères."
    )]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Le prenom doit être supérieur à 2 caractères.",
        maxMessage: "Le prenom ne peut pas être supérieur à 20 caractères."
    )]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone = null;


    #[Assert\Email]
    #[ORM\Column(length: 180)]
    private ?string $mail = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sites $sites_no_site = null;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(length: 255, nullable: true)]
    private $image;

    #[Assert\Image]
    #[Vich\UploadableField(mapping: "product_image", fileNameProperty: "image")]
    private $imageFile;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt;

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
        return (string)$this->pseudo;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserId(): ?int
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (!$this->administrateur)
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_USER';
        else {
            // Si administrateur = 1 ou true, le rôle admin lui est assigné
            $roles[] = 'ROLE_ADMIN';
        }

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
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

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'pseudo' => $this->pseudo,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'mail' => $this->mail,
            'roles' => $this->roles,
            'password' => $this->password,
            'sites_no_site' => $this->sites_no_site,
            'imageFile' => base64_encode($this->imageFile),
            'updatedAt' => $this->updatedAt,
            'administrateur' => $this->administrateur,
            'actif' => $this->actif
        ];

    }

    public function __unserialize(array $serialized)
    {
        $this->id = $serialized['id'];
        $this->pseudo = $serialized['pseudo'];
        $this->nom = $serialized['id'];
        $this->prenom = $serialized['nom'];
        $this->telephone = $serialized['telephone'];
        $this->mail = $serialized['mail'];
        $this->roles = $serialized['roles'];
        $this->password = $serialized['password'];
        $this->sites_no_site = $serialized['sites_no_site'];
        $this->imageFile = base64_decode($serialized['imageFile']);
        $this->updatedAt = $serialized['updatedAt'];
        $this->administrateur = $serialized['administrateur'];
        $this->actif = $serialized['actif'];

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

}
