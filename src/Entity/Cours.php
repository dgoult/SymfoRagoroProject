<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $date_fin = null;

    #[ORM\Column]
    private ?int $duree_minutes = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Intervenant $Intervenant = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Matiere $Matiere = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: CommentaireCours::class)]
    private Collection $commentaireCours;

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
        return $this->date_debut;
    }

    public function getDateDebutString(): ?string
    {
        return $this->date_debut->format('Y-m-d H:i:s');
    }

    public function setDateDebut(DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->date_fin;
    }

    public function getDateFinString(): ?string
    {
        return $this->date_fin->format('Y-m-d H:i:s');
    }

    public function setDateFin(DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
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

    public function addCommentaireCour(CommentaireCours $commentaireCour): self
    {
        if (!$this->commentaireCours->contains($commentaireCour)) {
            $this->commentaireCours->add($commentaireCour);
            $commentaireCour->setCours($this);
        }

        return $this;
    }

    public function removeCommentaireCour(CommentaireCours $commentaireCour): self
    {
        if ($this->commentaireCours->removeElement($commentaireCour)) {
            // set the owning side to null (unless already changed)
            if ($commentaireCour->getCours() === $this) {
                $commentaireCour->setCours(null);
            }
        }

        return $this;
    }
}
