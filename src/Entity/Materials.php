<?php

namespace App\Entity;

use App\Repository\MaterialsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialsRepository::class)]
class Materials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_material = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'materials_rental', targetEntity: Rentals::class)]
    private Collection $rental_material;

    public function __construct()
    {
        $this->rental_material = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }
    public function __toString()
    {
        return $this->name_material;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMaterial(): ?string
    {
        return $this->name_material;
    }

    public function setNameMaterial(string $name_material): self
    {
        $this->name_material = $name_material;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Rentals>
     */
    public function getRentalMaterial(): Collection
    {
        return $this->rental_material;
    }

    public function addRentalMaterial(Rentals $rentalMaterial): self
    {
        if (!$this->rental_material->contains($rentalMaterial)) {
            $this->rental_material->add($rentalMaterial);
            $rentalMaterial->setMaterialsRental($this);
        }

        return $this;
    }

    public function removeRentalMaterial(Rentals $rentalMaterial): self
    {
        if ($this->rental_material->removeElement($rentalMaterial)) {
            // set the owning side to null (unless already changed)
            if ($rentalMaterial->getMaterialsRental() === $this) {
                $rentalMaterial->setMaterialsRental(null);
            }
        }

        return $this;
    }
}
