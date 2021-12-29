<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    const PROMOTION_ENABLE = true;
    const PROMOTION_DISABLE = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $expiratedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityAvailable;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discountPercentage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discountValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="promotions")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="promotions")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="promotions")
     */
    private $orders;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $minAmount;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getExpiratedAt(): ?\DateTimeImmutable
    {
        return $this->expiratedAt;
    }

    public function setExpiratedAt(?\DateTimeImmutable $expiratedAt): self
    {
        $this->expiratedAt = $expiratedAt;

        return $this;
    }

    public function getQuantityAvailable(): ?int
    {
        return $this->quantityAvailable;
    }

    public function setQuantityAvailable(?int $quantityAvailable): self
    {
        $this->quantityAvailable = $quantityAvailable;

        return $this;
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?int $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getDiscountValue(): ?int
    {
        return $this->discountValue;
    }

    public function setDiscountValue(?int $discountValue): self
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addPromotion($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removePromotion($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addPromotion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removePromotion($this);
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addPromotion($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removePromotion($this);
        }

        return $this;
    }

    public function getMinAmount(): ?float
    {
        return $this->minAmount;
    }

    public function setMinAmount(?float $minAmount): self
    {
        $this->minAmount = $minAmount;

        return $this;
    }
}
