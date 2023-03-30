<?php

namespace App\Entity;

use App\Repository\CommentaireCourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireCourRepository::class)]
class CommentaireCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire_text = null;

    #[ORM\ManyToOne(inversedBy: 'commentaireCours')]
    private ?Cours $cours = null;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireText(): ?string
    {
        return $this->commentaire_text;
    }

    public function setCommentaireText(?string $commentaire_text): self
    {
        $this->commentaire_text = $commentaire_text;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
