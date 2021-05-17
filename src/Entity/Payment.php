<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comment")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Crowdfunding::class, inversedBy="comment")
     * @ORM\JoinColumn(nullable=false)
     */
    private Crowdfunding $crowdfunding;

    /**
     * @ORM\ManyToOne(targetEntity=Bonus::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private Crowdfunding $bonus;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $sentAt;

    public function __construct()
    {
        $this->setSentAt(new DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCrowdfunding(): ?Crowdfunding
    {
        return $this->crowdfunding;
    }

    public function setCrowdfunding(?Crowdfunding $crowdfunding): self
    {
        $this->crowdfunding = $crowdfunding;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSentAt(): DateTimeInterface
    {
        return $this->sentAt;
    }

    /**
     * @param DateTimeInterface $sentAt
     */
    public function setSentAt(DateTimeInterface $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

    /**
     * @return Crowdfunding
     */
    public function getBonus(): Crowdfunding
    {
        return $this->bonus;
    }

    /**
     * @param Crowdfunding $bonus
     */
    public function setBonus(Crowdfunding $bonus): void
    {
        $this->bonus = $bonus;
    }

}
