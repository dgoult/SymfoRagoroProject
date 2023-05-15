<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;


    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $civilite = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: CommentaireCours::class)]
    private Collection $commentaireCours;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Intervenant $intervenant = null;

    public function __construct()
    {
        $this->commentaireCours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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


    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCommentairesCours(): ?CommentaireCours
    {
        return $this->commentairesCours;
    }

    public function setCommentairesCours(CommentaireCours $commentairesCours): self
    {
        // set the owning side of the relation if necessary
        if ($commentairesCours->getAuthor() !== $this) {
            $commentairesCours->setAuthor($this);
        }

        $this->commentairesCours = $commentairesCours;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->civilite . ' ' . $this->nom . ' ' . $this->prenom;
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

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

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
            $commentaireCour->setAuthor($this);
        }

        return $this;
    }

    public function removeCommentaireCour(CommentaireCours $commentaireCour): self
    {
        if ($this->commentaireCours->removeElement($commentaireCour)) {
            // set the owning side to null (unless already changed)
            if ($commentaireCour->getAuthor() === $this) {
                $commentaireCour->setAuthor(null);
            }
        }

        return $this;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Intervenant $intervenant): self
    {
        // unset the owning side of the relation if necessary
        if ($intervenant === null && $this->intervenant !== null) {
            $this->intervenant->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($intervenant !== null && $intervenant->getUser() !== $this) {
            $intervenant->setUser($this);
        }

        $this->intervenant = $intervenant;

        return $this;
    }
}
