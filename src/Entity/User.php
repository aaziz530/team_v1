<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;


    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Medecin::class, cascade: ['persist'])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: President::class, cascade: ['persist'])]
    private ?President $president = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Entraineur::class, cascade: ['persist'])]
    private ?Entraineur $entraineur = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Joueur::class, cascade: ['persist'])]
    private ?Joueur $joueur = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Photographe::class, cascade: ['persist'])]
    private ?Photographe $photographe = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
  
    public function setUsername(string $username): self
    {
        $this->username = $username;
  
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        
        if ($medecin && $medecin->getUser() !== $this) {
            $medecin->setUser($this);
        }

        return $this;
    }

    public function getPresident(): ?President
    {
        return $this->president;
    }

    public function setPresident(?President $president): self
    {
        $this->president = $president;

        
        if ($president && $president->getUser() !== $this) {
            $president->setUser($this);
        }

        return $this;
    }

    public function getEntraineur(): ?Entraineur
    {
        return $this->entraineur;
    }

    public function setEntraineur(?Entraineur $entraineur): self
    {
        $this->entraineur = $entraineur;

        
        if ($entraineur && $entraineur->getUser() !== $this) {
            $entraineur->setUser($this);
        }

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): self
    {
        $this->joueur = $joueur;

        
        if ($joueur && $joueur->getUser() !== $this) {
            $joueur->setUser($this);
        }

        return $this;
    }

    public function getPhotographe(): ?Photographe
    {
        return $this->photographe;
    }

    public function setPhotographe(?Photographe $photographe): self
    {
        $this->photographe = $photographe;

        
        if ($photographe && $photographe->getUser() !== $this) {
            $photographe->setUser($this);
        }

        return $this;
    }
    
}
