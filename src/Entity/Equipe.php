<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fondation = null;

    /**
     * @var Collection<int, entraineur>
     */
    #[ORM\OneToMany(targetEntity: entraineur::class, mappedBy: 'equipe')]
    private Collection $entraineurs;

    /**
     * @var Collection<int, joueur>
     */
    #[ORM\OneToMany(targetEntity: joueur::class, mappedBy: 'equipe')]
    private Collection $joueurs;

    #[ORM\OneToOne(inversedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?president $president = null;

    /**
     * @var Collection<int, medecin>
     */
    #[ORM\OneToMany(targetEntity: medecin::class, mappedBy: 'equipe')]
    private Collection $medecins;

    /**
     * @var Collection<int, photographe>
     */
    #[ORM\OneToMany(targetEntity: photographe::class, mappedBy: 'equipe')]
    private Collection $photographes;

    public function __construct()
    {
        $this->entraineurs = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
        $this->medecins = new ArrayCollection();
        $this->photographes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateFondation(): ?\DateTimeInterface
    {
        return $this->date_fondation;
    }

    public function setDateFondation(\DateTimeInterface $date_fondation): static
    {
        $this->date_fondation = $date_fondation;

        return $this;
    }

    /**
     * @return Collection<int, entraineur>
     */
    public function getEntraineurs(): Collection
    {
        return $this->entraineurs;
    }

    public function addEntraineur(entraineur $entraineur): static
    {
        if (!$this->entraineurs->contains($entraineur)) {
            $this->entraineurs->add($entraineur);
            $entraineur->setEquipe($this);
        }

        return $this;
    }

    public function removeEntraineur(entraineur $entraineur): static
    {
        if ($this->entraineurs->removeElement($entraineur)) {
            // set the owning side to null (unless already changed)
            if ($entraineur->getEquipe() === $this) {
                $entraineur->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, joueur>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(joueur $joueur): static
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipe() === $this) {
                $joueur->setEquipe(null);
            }
        }

        return $this;
    }

    public function getPresident(): ?president
    {
        return $this->president;
    }

    public function setPresident(?president $president): static
    {
        $this->president = $president;

        return $this;
    }

    /**
     * @return Collection<int, medecin>
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(medecin $medecin): static
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins->add($medecin);
            $medecin->setEquipe($this);
        }

        return $this;
    }

    public function removeMedecin(medecin $medecin): static
    {
        if ($this->medecins->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getEquipe() === $this) {
                $medecin->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, photographe>
     */
    public function getPhotographes(): Collection
    {
        return $this->photographes;
    }

    public function addPhotographe(photographe $photographe): static
    {
        if (!$this->photographes->contains($photographe)) {
            $this->photographes->add($photographe);
            $photographe->setEquipe($this);
        }

        return $this;
    }

    public function removePhotographe(photographe $photographe): static
    {
        if ($this->photographes->removeElement($photographe)) {
            // set the owning side to null (unless already changed)
            if ($photographe->getEquipe() === $this) {
                $photographe->setEquipe(null);
            }
        }

        return $this;
    }
}
