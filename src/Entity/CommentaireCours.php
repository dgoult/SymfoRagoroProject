<?php

namespace App\Entity;

use App\Repository\CommentaireCourRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[ORM\Entity(repositoryClass: CommentaireCourRepository::class)]
class CommentaireCours implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * @Groups({"commentairejson"})
     */
    private ?int $id = null;


    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @Groups({"commentairejson"})
     */
    private ?string $commentaire_text = null;

    #[ORM\ManyToOne(inversedBy: 'commentaireCours')]
    private ?Cours $cours = null;

    #[ORM\Column]
    /**
     * @Groups({"commentairejson"})
     */
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    /**
     * @Groups({"commentairejson"})
     */
    private ?DateTimeInterface $date_creation = null;

    #[ORM\OneToOne(inversedBy: 'commentairesCours', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @throws ExceptionInterface
     */
    public function toJson(): bool|string
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);

        return $serializer->serialize($this, 'json', [
            'groups' => ['commentairejson'],
        ]);
    }

    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->id,
            'commentaire_text' => $this->commentaire_text,
            'date_creation' => $this->date_creation,
            'author' => $this->author->getFullName()
        );
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
