<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[Index(fields: ["id", "stock", "expiresAt", "bestBefore"], name: "search_index")]
#[UniqueEntity('title')]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $title;

    #[Ignore]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $bestBefore;
    #[Ignore]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $expiresAt;

    #[ORM\Column(type: 'integer')]
    private ?int $stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBestBefore(): ?\DateTimeInterface
    {
        return $this->bestBefore;
    }

    public function setBestBefore(\DateTimeInterface $bestBefore): self
    {
        $this->bestBefore = $bestBefore;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

}
