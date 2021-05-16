<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private ?Category $parent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;


    public function getId(): int
    {
        return $this->id;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Crowdfunding[]
     */
    public function getCrowdfunding(): Collection
    {
        return $this->crowdfunding;
    }

    public function addCrowdfunding(Crowdfunding $crowdfunding): self
    {
        if (!$this->crowdfunding->contains($crowdfunding)) {
            $this->crowdfunding[] = $crowdfunding;
            $crowdfunding->setA($this);
        }

        return $this;
    }

    public function removeCrowdfunding(Crowdfunding $crowdfunding): self
    {
        if ($this->crowdfunding->removeElement($crowdfunding)) {
            // set the owning side to null (unless already changed)
            if ($crowdfunding->getA() === $this) {
                $crowdfunding->setA(null);
            }
        }

        return $this;
    }
}
