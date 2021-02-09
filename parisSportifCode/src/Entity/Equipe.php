<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
//use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $contry;

    /**
     * @ORM\OneToMany(targetEntity=Joueurs::class, mappedBy="equipe")
     * @var Collection<int, Joueurs>|null
     */
    private ?Collection $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     */
    private ?Sport $sport;

    /**
     * @ORM\ManyToMany(targetEntity=EvenementSport::class, mappedBy="equipes")
     * @var Collection<int, EvenementSport>|null
     */
    private ?Collection $evenementSports;


    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->evenementSports = new ArrayCollection();

    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContry(): ?string
    {
        return $this->contry;
    }

    /**
     * @param string|null $contry
     * @return Equipe
     */
    public function setContry(?string $contry): self
    {
        $this->contry = $contry;
        return $this;
    }

    /**
     * @return Collection<int, Joueurs>|Joueurs[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueurs $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->setEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(Joueurs $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipe() === $this) {
                $joueur->setEquipe(null);
            }
        }

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|EvenementSport[]
     */
    public function getEvenementSports(): Collection
    {
        return $this->evenementSports;
    }

    public function addEvenementSport(EvenementSport $evenementSport): self
    {
        if (!$this->evenementSports->contains($evenementSport)) {
            $this->evenementSports[] = $evenementSport;
            $evenementSport->addEquipe($this);
        }

        return $this;
    }

    public function removeEvenementSport(EvenementSport $evenementSport): self
    {
        if ($this->evenementSports->removeElement($evenementSport)) {
            $evenementSport->removeEquipe($this);
        }

        return $this;
    }


}
