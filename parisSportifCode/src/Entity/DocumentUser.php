<?php

namespace App\Entity;

use App\Repository\DocumentUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DocumentUserRepository::class)
 */
class DocumentUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $brochureFilename = ' ';

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private ?bool $isValid = false;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString(): string
    {
        return $this->getBrochureFilename();
    }

    public function getBrochureFilename(): string
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename($brochureFilename):self
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }

    public function isValid(): self
    {
        $this -> isValid = true;
        return $this;
    }
}
