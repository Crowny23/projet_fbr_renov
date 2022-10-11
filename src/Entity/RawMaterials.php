<?php

namespace App\Entity;

use App\Repository\RawMaterialsRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RawMaterialsRepository::class)]
class RawMaterials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_raw_material = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'raw_material', targetEntity: RawMaterialsOrdered::class)]
    private Collection $raw_material_ordered;

    #[ORM\ManyToOne(inversedBy: 'rawMaterials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RawMaterialsCategories $category = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    public function __construct()
    {
        $this->raw_material_ordered = new ArrayCollection();
        $date = new DateTimeImmutable();
        $timezone = new DateTimeZone('Europe/Paris');
        $created_at =  $date->setTimezone($timezone);
        $this->created_at = $created_at;
    }

    public function __toString()
    {
        return $this->name_raw_material;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRawMaterial(): ?string
    {
        return $this->name_raw_material;
    }

    public function setNameRawMaterial(string $name_raw_material): self
    {
        $this->name_raw_material = $name_raw_material;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, RawMaterialsOrdered>
     */
    public function getRawMaterialOrdered(): Collection
    {
        return $this->raw_material_ordered;
    }

    public function addRawMaterialOrdered(RawMaterialsOrdered $rawMaterialOrdered): self
    {
        if (!$this->raw_material_ordered->contains($rawMaterialOrdered)) {
            $this->raw_material_ordered->add($rawMaterialOrdered);
            $rawMaterialOrdered->setRawMaterial($this);
        }

        return $this;
    }

    public function removeRawMaterialOrdered(RawMaterialsOrdered $rawMaterialOrdered): self
    {
        if ($this->raw_material_ordered->removeElement($rawMaterialOrdered)) {
            // set the owning side to null (unless already changed)
            if ($rawMaterialOrdered->getRawMaterial() === $this) {
                $rawMaterialOrdered->setRawMaterial(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?RawMaterialsCategories
    {
        return $this->category;
    }

    public function setCategory(?RawMaterialsCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
