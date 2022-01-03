<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $ISO;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $ISO3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $vat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getISO(): ?string
    {
        return $this->ISO;
    }

    public function setISO(string $ISO): self
    {
        $this->ISO = $ISO;

        return $this;
    }

    public function getISO3(): ?string
    {
        return $this->ISO3;
    }

    public function setISO3(string $ISO3): self
    {
        $this->ISO3 = $ISO3;

        return $this;
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

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }
}
