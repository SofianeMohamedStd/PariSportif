<?php

namespace App\Entity;

use App\Repository\JoueursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JoueursRepository::class)
 */
class Joueurs
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
     * @ORM\Column(type="string")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\Regex(
     *     pattern="/^[a-zA-ZÀ-ÿ-]{2,16}$/")
     * @Groups({"naming"})
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\ExpressionLanguageSyntax(
     *     allowedVariables={"titulaire", "remplaçant", "suspendu", "blessé"}
     * )
     * @Groups({"status"})
     */
    private ?string $status;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="joueurs")
     */
    private ?Equipe $equipe;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     */
    private ?Sport $sport;

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $team): self
    {
        $this->equipe = $team;

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

}
