<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private ?int $nbTeams;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private ?int $nbPlayers;

    /**
     * @ORM\OneToMany(targetEntity=EvenementSport::class, mappedBy="competion")
     * @var Collection<int, EvenementSport>|null
     */
    private ?Collection $competition;

    /**
     * @ORM\OneToMany(targetEntity=EvenementSport::class, mappedBy="sport")
     * @var Collection<int, EvenementSport>|null
     */
    private ?Collection $evenements;


    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getNbTeams(): ?int
    {
        return $this->nbTeams;
    }

    public function setNbTeams(?int $nbTeams): self
    {
        $this->nbTeams = $nbTeams;

        return $this;
    }

    public function getNbPlayers(): ?int
    {
        return $this->nbPlayers;
    }

    public function setNbPlayers(?int $nbPlayers): self
    {
        $this->nbPlayers = $nbPlayers;

        return $this;
    }

    /**
     * @return Collection<int, EvenementSport>|EvenementSport[]
     */
    public function getEvenement(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(EvenementSport $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setSport($this);
        }

        return $this;
    }

    public function removeEvenement(EvenementSport $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getSport() === $this) {
                $evenement->setSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Competition>|Competition[]
     */
    public function getCompetition(): Collection
    {
        return $this->competition;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competition->contains($competition)) {
            $this->competition[] = $competition;
            $competition->setSport($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competition->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getSport() === $this) {
                $competition->setSport(null);
            }
        }

        return $this;
    }
}
