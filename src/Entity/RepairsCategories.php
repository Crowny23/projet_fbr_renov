<?php

namespace App\Entity;

use App\Repository\RepairsCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepairsCategoriesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RepairsCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_repairs_category = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Repairs::class)]
    private Collection $repairs;

    public function __toString()
    {
        return $this->name_repairs_category;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRepairsCategory(): ?string
    {
        return $this->name_repairs_category;
    }

    public function setNameRepairsCategory(string $name_repairs_category): self
    {
        $this->name_repairs_category = $name_repairs_category;

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

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->repairs = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Repairs>
     */
    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function addRepair(Repairs $repair): self
    {
        if (!$this->repairs->contains($repair)) {
            $this->repairs->add($repair);
            $repair->setCategory($this);
        }

        return $this;
    }

    public function removeRepair(Repairs $repair): self
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getCategory() === $this) {
                $repair->setCategory(null);
            }
        }

        return $this;
    }
}
