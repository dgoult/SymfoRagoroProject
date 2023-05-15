<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $duree_minutes = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Intervenant $Intervenant = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Matiere $Matiere = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: CommentaireCours::class)]
    private Collection $commentaireCours;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $date_cours;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $heure_debut;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $heure_fin;
    

    public function __construct()
    {
        $this->commentaireCours = new ArrayCollection();
    }

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

    public function getDateDebut(): ?DateTimeInterface
    {
        $date = $this->date_cours;
        $time = $this->heure_debut;

        return $date->setTime(
            $time->format('H'),
            $time->format('i'),
            $time->format('s')
        );
    }

    public function getDateDebutString(): ?string
    {
        $date = $this->date_cours;
        $time = $this->heure_debut;

        return $date->setTime(
            $time->format('H'),
            $time->format('i'),
            $time->format('s')
        )->format('Y-m-d H:i:s');
    }

    public function getDateFin(): ?DateTimeInterface
    {
        $date = $this->date_cours;
        $time = $this->heure_fin;

        return $date->setTime(
            $time->format('H'),
            $time->format('i'),
            $time->format('s')
        );
    }

    public function getDateFinString(): ?string
    {
        $date = $this->date_cours;
        $time = $this->heure_fin;

        return $date->setTime(
            $time->format('H'),
            $time->format('i'),
            $time->format('s')
        )->format('Y-m-d H:i:s');
    }

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function setDureeMinutes(int $duree_minutes): self
    {
        $this->duree_minutes = $duree_minutes;

        return $this;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->Intervenant;
    }

    public function setIntervenant(?Intervenant $Intervenant): self
    {
        $this->Intervenant = $Intervenant;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->Matiere;
    }

    public function setMatiere(?Matiere $Matiere): self
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    /**
     * @return Collection<int, CommentaireCours>
     */
    public function getCommentaireCours(): Collection
    {
        return $this->commentaireCours;
    }

    public function addCommentaireCours(CommentaireCours $commentaireCour): self
    {
        if (!$this->commentaireCours->contains($commentaireCour)) {
            $this->commentaireCours->add($commentaireCour);
            $commentaireCour->setCours($this);
        }

        return $this;
    }

    public function removeCommentaireCours(CommentaireCours $commentaireCour): self
    {
        if ($this->commentaireCours->removeElement($commentaireCour)) {
            // set the owning side to null (unless already changed)
            if ($commentaireCour->getCours() === $this) {
                $commentaireCour->setCours(null);
            }
        }

        return $this;
    }

    public function getDateCours(): ?DateTimeInterface
    {
        return $this->date_cours;
    }

    public function setDateCours(DateTimeInterface $date_cours): self
    {
        $this->date_cours = $date_cours;

        return $this;
    }

    public function getHeureDebut(): ?DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getHeureFin(): ?DateTimeInterface
    {
        return $this->heure_fin;
    }

    /**
     * @param DateTimeInterface|null $heure_fin
     */
    public function setHeureFin(?DateTimeInterface $heure_fin): void
    {
        $this->heure_fin = $heure_fin;
    }

}
