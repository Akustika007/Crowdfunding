<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Crowdfunding::class, inversedBy="rating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crowdfunding;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCrowdfunding(): Crowdfunding
    {
        return $this->crowdfunding;
    }

    public function setCrowdfunding(Crowdfunding $crowdfunding): self
    {
        $this->crowdfunding = $crowdfunding;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
