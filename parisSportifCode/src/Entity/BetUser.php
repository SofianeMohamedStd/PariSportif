<?php

namespace App\Entity;

use App\Repository\BetUserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetUserRepository::class)
 */
class BetUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $amountBetDate;
    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     * @Assert\Positive()
     * @Assert\LessThanOrEqual(value="10000")
     */
    private ?int $amountBet;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     * @Assert\Positive()
     */
    private ?int $gainPossible;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="betUsers")
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Bet::class, inversedBy="betUsers")
     */
    private $bet;


    public function __construct()
    {
        $this->amountBetDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmountBetDate(): ?\DateTimeInterface
    {
        return $this->amountBetDate;
    }

    public function getAmountBet(): ?float
    {
        return $this -> amountBet / 100;
    }

    public function setAmountBet(?int $amountBet, int $amountUser): bool
    {

        if ($amountBet > $amountUser) {
            return false;
        }
            $this -> amountBet = ($amountBet * 100);

        return true;
    }

    public function getGainPossible () : ?float
    {
        return $this -> gainPossible/100;
    }

    public function setGainPossible ( ?float $amountBet, float $cote ) : self
    {
        $this -> gainPossible = ($amountBet * $cote)*100;
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

    public function getBet(): ?Bet
    {
        return $this->bet;
    }

    public function setBet(?Bet $bet): self
    {
        $this->bet = $bet;

        return $this;
    }
}
