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

    const PROMOTION_TYPE_CART = "CART";
    const PROMOTION_TYPE_USER = "USER";
    const PROMOTION_TYPE_PRODUCT = "PRODUCT";

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
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $expiratedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $usageLimitByUser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbProductStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minPriceCart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minNbProductCart;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="promotions")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discountPercentage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discountFix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $freeShippingFees;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="promotions")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=PromotionHistory::class, mappedBy="promotion")
     */
    private $promotionHistories;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->promotionHistories = new ArrayCollection();
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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getExpiratedAt(): ?\DateTimeImmutable
    {
        return $this->expiratedAt;
    }

    public function setExpiratedAt(\DateTimeImmutable $expiratedAt): self
    {
        $this->expiratedAt = $expiratedAt;

        return $this;
    }

    public function getUsageLimitByUser(): ?int
    {
        return $this->usageLimitByUser;
    }

    public function setUsageLimitByUser(int $usageLimitByUser): self
    {
        $this->usageLimitByUser = $usageLimitByUser;

        return $this;
    }

    public function getNbProductStock(): ?int
    {
        return $this->nbProductStock;
    }

    public function setNbProductStock(?int $nbProductStock): self
    {
        $this->nbProductStock = $nbProductStock;

        return $this;
    }

    public function getMinPriceCart(): ?int
    {
        return $this->minPriceCart;
    }

    public function setMinPriceCart(?int $minPriceCart): self
    {
        $this->minPriceCart = $minPriceCart;

        return $this;
    }

    public function getMinNbProductCart(): ?int
    {
        return $this->minNbProductCart;
    }

    public function setMinNbProductCart(?int $minNbProductCart): self
    {
        $this->minNbProductCart = $minNbProductCart;

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

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?int $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getDiscountFix(): ?int
    {
        return $this->discountFix;
    }

    public function setDiscountFix(?int $discountFix): self
    {
        $this->discountFix = $discountFix;

        return $this;
    }

    public function getFreeShippingFees(): ?bool
    {
        return $this->freeShippingFees;
    }

    public function setFreeShippingFees(?bool $freeShippingFees): self
    {
        $this->freeShippingFees = $freeShippingFees;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return Collection|PromotionHistory[]
     */
    public function getPromotionHistories(): Collection
    {
        return $this->promotionHistories;
    }

    public function addPromotionHistory(PromotionHistory $promotionHistory): self
    {
        if (!$this->promotionHistories->contains($promotionHistory)) {
            $this->promotionHistories[] = $promotionHistory;
            $promotionHistory->setPromotion($this);
        }

        return $this;
    }

    public function removePromotionHistory(PromotionHistory $promotionHistory): self
    {
        if ($this->promotionHistories->removeElement($promotionHistory)) {
            // set the owning side to null (unless already changed)
            if ($promotionHistory->getPromotion() === $this) {
                $promotionHistory->setPromotion(null);
            }
        }

        return $this;
    }
}
