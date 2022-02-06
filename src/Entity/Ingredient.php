<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[UniqueEntity('title')]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[Ignore]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $bestBefore;
    #[Ignore]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $expiresAt;

    #[ORM\Column(type: 'integer')]
    private ?int $stock;

    #[Ignore]
    #[ORM\ManyToMany(targetEntity: Food::class, mappedBy: 'ingredients')]
    private ArrayCollection $foods;

    public function __construct()
    {
        $this->foods = new ArrayCollection();
    }

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

    /**
     * @return Collection|Food[]
     */
    public function getFoods(): Collection
    {
        return $this->foods;
    }

    public function addFood(Food $food): self
    {
        if (!$this->foods->contains($food)) {
            $this->foods[] = $food;
            $food->addIngredient($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->foods->removeElement($food)) {
            $food->removeIngredient($this);
        }

        return $this;
    }
}
