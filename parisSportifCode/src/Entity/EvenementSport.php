<?php

namespace App\Entity;

use App\Repository\EvenementSportRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvenementSportRepository::class)
 */
class EvenementSport
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
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="today", groups={"beginDate"})
     */
    private ?DateTimeInterface $beginDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $eventPlace;


    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="evenement")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="evenementSport")
     */
    private $equipe;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="evenement")
     */
    private $competionn;

    public function __construct()
    {
        $this->equipe = new ArrayCollection();
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
    public function setName(?string $name): ?self
    {
        $this->name = $name;

        return $this;
    }
    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }
    public function setBeginDate(?\DateTimeInterface $beginDate): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }
    public function getEventPlace(): ?string
    {
        return $this->eventPlace;
    }
    public function setEventPlace($eventPlace): self
    {
        $this->eventPlace = $eventPlace;
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
     * @return Collection|Equipe[]
     */
    public function getEquipe(): Collection
    {
        return $this->equipe;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipe->contains($equipe)) {
            $this->equipe[] = $equipe;
            $equipe->setEvenementSport($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipe->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getEvenementSport() === $this) {
                $equipe->setEvenementSport(null);
            }
        }

        return $this;
    }

    public function getCompetionn(): ?Competition
    {
        return $this->competionn;
    }

    public function setCompetionn(?Competition $competitionn): self
    {
        $this->competionn = $competitionn;

        return $this;
    }
}
