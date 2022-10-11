<?php

namespace App\Entity;

use App\Repository\RawMaterialsOrderedRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RawMaterialsOrderedRepository::class)]
class RawMaterialsOrdered
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'raw_material_ordered')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

    #[ORM\ManyToOne(inversedBy: 'raw_material_ordered')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RawMaterials $raw_material = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_price_raw_material = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getRawMaterial(): ?RawMaterials
    {
        return $this->raw_material;
    }

    public function setRawMaterial(?RawMaterials $raw_material): self
    {
        $this->raw_material = $raw_material;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getTotalPriceRawMaterial(): ?int
    {
        return $this->total_price_raw_material;
    }

    public function setTotalPriceRawMaterial(?int $total_price_raw_material): self
    {
        $this->total_price_raw_material = $total_price_raw_material;

        return $this;
    }
}
