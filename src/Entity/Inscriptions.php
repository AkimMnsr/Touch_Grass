<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionsRepository::class)]
class Inscriptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_inscription = null;

    #[ORM\ManyToMany(targetEntity: Sorties::class)]
    private Collection $sorties_no_sortie;

    #[ORM\ManyToMany(targetEntity: Participants::class)]
    private Collection $participants_no_participant;

    #[ORM\OneToMany(mappedBy: 'id_inscription', targetEntity: Sorties::class)]
    private Collection $sorties;

    public function __construct()
    {
        $this->sorties_no_sortie = new ArrayCollection();
        $this->participants_no_participant = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection<int, Sorties>
     */
    public function getSortiesNoSortie(): Collection
    {
        return $this->sorties_no_sortie;
    }

    public function addSortiesNoSortie(Sorties $sortiesNoSortie): self
    {
        if (!$this->sorties_no_sortie->contains($sortiesNoSortie)) {
            $this->sorties_no_sortie->add($sortiesNoSortie);
        }

        return $this;
    }

    public function removeSortiesNoSortie(Sorties $sortiesNoSortie): self
    {
        $this->sorties_no_sortie->removeElement($sortiesNoSortie);

        return $this;
    }

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipantsNoParticipant(): Collection
    {
        return $this->participants_no_participant;
    }

    public function addParticipantsNoParticipant(Participants $participantsNoParticipant): self
    {
        if (!$this->participants_no_participant->contains($participantsNoParticipant)) {
            $this->participants_no_participant->add($participantsNoParticipant);
        }

        return $this;
    }

    public function removeParticipantsNoParticipant(Participants $participantsNoParticipant): self
    {
        $this->participants_no_participant->removeElement($participantsNoParticipant);

        return $this;
    }

    /**
     * @return Collection<int, Sorties>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sorties $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setIdInscription($this);
        }

        return $this;
    }

    public function removeSorty(Sorties $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getIdInscription() === $this) {
                $sorty->setIdInscription(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->id;
    }
}
