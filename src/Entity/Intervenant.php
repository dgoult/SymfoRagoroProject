<?php

namespace App\Entity;

use App\Repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: IntervenantRepository::class)]
class Intervenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialite_professionnelle = null;

    #[ORM\OneToMany(mappedBy: 'Intervenant', targetEntity: Cours::class)]
    private Collection $cours;

    #[ORM\OneToOne(inversedBy: 'intervenant', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[Pure] public function __construct()
    {
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->user->getNom() . ' ' . $this->user->getPrenom();
    }

    public function getSpecialiteProfessionnelle(): ?string
    {
        return $this->specialite_professionnelle;
    }

    public function setSpecialiteProfessionnelle(?string $specialite_professionnelle): self
    {
        $this->specialite_professionnelle = $specialite_professionnelle;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setIntervenant($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getIntervenant() === $this) {
                $cour->setIntervenant(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
