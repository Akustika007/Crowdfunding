<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $text;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Crowdfunding::class, inversedBy="comment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crowdfunding;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCrowdfunding(): ?Crowdfunding
    {
        return $this->crowdfunding;
    }

    public function setCrowdfunding(?Crowdfunding $crowdfunding): self
    {
        $this->crowdfunding = $crowdfunding;

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


}
