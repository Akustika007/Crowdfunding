<?php

namespace App\Entity;

use App\Repository\CrowdfundingRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrowdfundingRepository", repositoryClass=CrowdfundingRepository::class)
 */
class Crowdfunding
{
    public const STATUS_NEW = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="crowdfunding")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="crowdfunding", orphanRemoval=true)
     */
    private Collection $comment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description_long;

    /**
     * @ORM\Column(type="string", length=128 , nullable=true)
     */
    private ?string $country;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $finished_at;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $money_purpose;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $money_collected;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="crowdfunding", orphanRemoval=true)
     */
    private $rating;
    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Category $category;

    /**
     * @ORM\OneToMany(targetEntity=Bonus::class, mappedBy="crowdfunding", orphanRemoval=true)
     */
    private $bonuses;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="crowdfunding", orphanRemoval=true)
     */
    private $payments;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
        $this->setUpdatedAt(new DateTimeImmutable());
        $this->rating = new ArrayCollection();
        $this->bonuses = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->money_collected = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setCrowdfunding($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCrowdfunding() === $this) {
                $comment->setCrowdfunding(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getDescriptionLong(): ?string
    {
        return $this->description_long;
    }

    public function setDescriptionLong(string $description_long): self
    {
        $this->description_long = $description_long;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finished_at;
    }

    public function setFinishedAt(\DateTimeInterface $finished_at): self
    {
        $this->finished_at = $finished_at;

        return $this;
    }

    public function getMoneyPurpose(): ?int
    {
        return $this->money_purpose;
    }

    public function setMoneyPurpose(int $money_purpose): self
    {
        $this->money_purpose = $money_purpose;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRating(): Collection
    {
        return $this->rating;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->rating->contains($rating)) {
            $this->rating[] = $rating;
            $rating->setCrowdfunding($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->rating->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getCrowdfunding() === $this) {
                $rating->setCrowdfunding(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Bonus[]
     */
    public function getBonuses(): Collection
    {
        return $this->bonuses;
    }

    public function addBonus(Bonus $bonus): self
    {
        if (!$this->bonuses->contains($bonus)) {
            $this->bonuses[] = $bonus;
            $bonus->setCrowdfunding($this);
        }

        return $this;
    }

    public function removeBonus(Bonus $bonus): self
    {
        if ($this->bonuses->removeElement($bonus)) {
            // set the owning side to null (unless already changed)
            if ($bonus->getCrowdfunding() === $this) {
                $bonus->setCrowdfunding(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMoneyCollected(): int
    {
        return $this->money_collected;
    }

    /**
     * @param int $money_collected
     */
    public function setMoneyCollected(int $money_collected): void
    {
        $this->money_collected = $money_collected;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setCrowdfunding($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getCrowdfunding() === $this) {
                $payment->setCrowdfunding(null);
            }
        }

        return $this;
    }

}