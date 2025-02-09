<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?int $phone_number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column]
    private ?int $numero_maillot = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\Column]
    private ?float $salaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_affectation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_contrat = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_carton_jaune = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_carton_rouge = null;

    #[ORM\OneToOne(inversedBy: 'joueur')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    private ?Equipe $equipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNumeroMaillot(): ?int
    {
        return $this->numero_maillot;
    }

    public function setNumeroMaillot(int $numero_maillot): static
    {
        $this->numero_maillot = $numero_maillot;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->date_affectation;
    }

    public function setDateAffectation(\DateTimeInterface $date_affectation): static
    {
        $this->date_affectation = $date_affectation;

        return $this;
    }

    public function getDateFinContrat(): ?\DateTimeInterface
    {
        return $this->date_fin_contrat;
    }

    public function setDateFinContrat(?\DateTimeInterface $date_fin_contrat): static
    {
        $this->date_fin_contrat = $date_fin_contrat;

        return $this;
    }

    public function getNbCartonJaune(): ?int
    {
        return $this->nb_carton_jaune;
    }

    public function setNbCartonJaune(?int $nb_carton_jaune): static
    {
        $this->nb_carton_jaune = $nb_carton_jaune;

        return $this;
    }

    public function getNbCartonRouge(): ?int
    {
        return $this->nb_carton_rouge;
    }

    public function setNbCartonRouge(?int $nb_carton_rouge): static
    {
        $this->nb_carton_rouge = $nb_carton_rouge;

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

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }
}
