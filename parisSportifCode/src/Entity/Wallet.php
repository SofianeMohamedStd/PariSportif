<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @UniqueEntity ("id")
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(type="integer", length=10)
     * @Assert\PositiveOrZero
     */
    private int $credit = 0;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCredit(): int
    {
        return $this -> credit;
    }

    public function addToCredit(int $credit)
    {
        if($credit <= 0){
            return false;
        }
        $this->credit += $credit;

        return true;
    }

    public function removeFromCredit(int $credit)
    {
        if($credit <= 0 or $credit > $this->getCredit()){
            return false;
        }
        $this->credit -= $credit;

        return true;
    }
}
