<?php

namespace App\Entity;

use App\Repository\BetRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank ()
     * @Assert\Regex(
     *     pattern="/^(?!\s*$)[-a-zA-Z\s]{1,100}$/")
     */
    private ?string $nameBet;
    /**
     * @ORM\Column(type="integer", length=3)
     * @Assert\NotBlank ()
     * @Assert\Positive
     * @Assert\GreaterThanOrEqual(value="110")
     */
    private ?int $cote;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(
     *      message="Date start vide",
     * )
     * @Assert\Type(
     *     type="datetime",
     *     message="Format incorrect"
     * )
     */
    private DateTimeInterface $dateBetLimit;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type(type="bool")
     */
    private bool $resultBet = false;

    /**
     * @ORM\ManyToOne(targetEntity=EvenementSport::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?EvenementSport $evenement;

    /**
     * @ORM\OneToMany(targetEntity=BetUser::class, mappedBy="bet")
     */
    private  $betUsers;



    public function __construct()
    {
        $this->betUsers = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getNameBet();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBet(): ?string
    {
        return $this -> nameBet;
    }

    public function setNameBet(?string $nameBet): self
    {
        $this -> nameBet = $nameBet;
        return $this;
    }

    public function getCote(): ?float
    {
        return $this -> cote / 100;
    }

    public function setCote(?float $cote): self
    {
        $this -> cote = $cote * 100;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateBetLimit(): ?DateTimeInterface
    {
        return $this->dateBetLimit;
    }

    /**
     * @param DateTimeInterface $DateBetLimit
     * @return Bet
     */
    public function setDateBetLimit(DateTimeInterface $DateBetLimit): self
    {
        $this->dateBetLimit = $DateBetLimit;
        return $this;
    }

    public function isResultBet(): bool
    {
        return $this -> resultBet;
    }

    public function setResultBet(bool $resultBet): self
    {
        $this -> resultBet = $resultBet;
        return $this;
    }

    public function getEvenement(): ?EvenementSport
    {
        return $this->evenement;
    }

    public function setEvenement(?EvenementSport $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * @return Collection|BetUser[]
     */
    public function getBetUsers(): Collection
    {
        return $this->betUsers;
    }

    public function addBetUser(BetUser $betUser): self
    {
        if (!$this->betUsers->contains($betUser)) {
            $this->betUsers[] = $betUser;
            $betUser->setBet($this);
        }

        return $this;
    }

    public function removeBetUser(BetUser $betUser): self
    {
        if ($this->betUsers->removeElement($betUser)) {
            // set the owning side to null (unless already changed)
            if ($betUser->getBet() === $this) {
                $betUser->setBet(null);
            }
        }

        return $this;
    }
}
