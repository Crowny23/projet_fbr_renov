<?php

namespace App\Entity;

use App\Repository\RawMaterialsCategoriesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RawMaterialsCategoriesRepository::class)]
class RawMaterialsCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: RawMaterials::class)]
    private Collection $rawMaterials;

    public function __construct()
    {
        $this->rawMaterials = new ArrayCollection();
        $this->created_at =  new DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, RawMaterials>
     */
    public function getRawMaterials(): Collection
    {
        return $this->rawMaterials;
    }

    public function addRawMaterial(RawMaterials $rawMaterial): self
    {
        if (!$this->rawMaterials->contains($rawMaterial)) {
            $this->rawMaterials->add($rawMaterial);
            $rawMaterial->setCategory($this);
        }

        return $this;
    }

    public function removeRawMaterial(RawMaterials $rawMaterial): self
    {
        if ($this->rawMaterials->removeElement($rawMaterial)) {
            // set the owning side to null (unless already changed)
            if ($rawMaterial->getCategory() === $this) {
                $rawMaterial->setCategory(null);
            }
        }

        return $this;
    }
}
