<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    const BRAND_ENABLE = true;
    const BRAND_DISABLE = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="brand")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=BrandCountryTVA::class, mappedBy="brand")
     */
    private $brandCountryTVAs;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->brandCountryTVAs = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

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
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BrandCountryTVA[]
     */
    public function getBrandCountryTVAs(): Collection
    {
        return $this->brandCountryTVAs;
    }

    public function addBrandCountryTVA(BrandCountryTVA $brandCountryTVA): self
    {
        if (!$this->brandCountryTVAs->contains($brandCountryTVA)) {
            $this->brandCountryTVAs[] = $brandCountryTVA;
            $brandCountryTVA->setBrand($this);
        }

        return $this;
    }

    public function removeBrandCountryTVA(BrandCountryTVA $brandCountryTVA): self
    {
        if ($this->brandCountryTVAs->removeElement($brandCountryTVA)) {
            // set the owning side to null (unless already changed)
            if ($brandCountryTVA->getBrand() === $this) {
                $brandCountryTVA->setBrand(null);
            }
        }

        return $this;
    }
}
