<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_order = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: RawMaterialsOrdered::class)]
    private Collection $raw_material_ordered;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Worksites $worksite = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Supplier $supplier = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_price = null;

    public function __construct()
    {
        $this->raw_material_ordered = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameOrder(): ?string
    {
        return $this->name_order;
    }

    public function setNameOrder(string $name_order): self
    {
        $this->name_order = $name_order;

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
            $rawMaterialOrdered->setOrders($this);
        }

        return $this;
    }

    public function removeRawMaterialOrdered(RawMaterialsOrdered $rawMaterialOrdered): self
    {
        if ($this->raw_material_ordered->removeElement($rawMaterialOrdered)) {
            // set the owning side to null (unless already changed)
            if ($rawMaterialOrdered->getOrders() === $this) {
                $rawMaterialOrdered->setOrders(null);
            }
        }

        return $this;
    }

    public function getWorksite(): ?Worksites
    {
        return $this->worksite;
    }

    public function setWorksite(?Worksites $worksite): self
    {
        $this->worksite = $worksite;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(?int $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }
}
