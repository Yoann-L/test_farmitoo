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
    private $vat;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="brand")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=BrandCountryVat::class, mappedBy="brand")
     */
    private $brandCountryVATs;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->brandCountryVATs = new ArrayCollection();
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

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(?float $vat): self
    {
        $this->vat = $vat;

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
     * @return Collection|BrandCountryVat[]
     */
    public function getBrandCountryVats(): Collection
    {
        return $this->brandCountryVATs;
    }

    public function addBrandCountryVat(BrandCountryVat $brandCountryVat): self
    {
        if (!$this->brandCountryVATs->contains($brandCountryVAT)) {
            $this->brandCountryVATs[] = $brandCountryVAT;
            $brandCountryVAT->setBrand($this);
        }

        return $this;
    }

    public function removeBrandCountryVat(BrandCountryVat $brandCountryVAT): self
    {
        if ($this->brandCountryVATs->removeElement($brandCountryVAT)) {
            // set the owning side to null (unless already changed)
            if ($brandCountryVAT->getBrand() === $this) {
                $brandCountryVAT->setBrand(null);
            }
        }

        return $this;
    }
}
