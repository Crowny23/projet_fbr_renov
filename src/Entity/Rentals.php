<?php

namespace App\Entity;

use App\Repository\RentalsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalsRepository::class)]
class Rentals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rentals_renter')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Renter $renter_rentals = null;

    #[ORM\ManyToOne(inversedBy: 'rental_material')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materials $materials_rental = null;

    #[ORM\Column]
    private ?int $quantity_rental = null;

    #[ORM\Column]
    private ?int $unit_price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'rental_worksite')]
    private ?Worksites $worksite_rental = null;

    #[ORM\ManyToOne(inversedBy: 'rental_repair')]
    private ?Repairs $repair_rental = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRenterRentals(): ?Renter
    {
        return $this->renter_rentals;
    }

    public function setRenterRentals(?Renter $renter_rentals): self
    {
        $this->renter_rentals = $renter_rentals;

        return $this;
    }

    public function getMaterialsRental(): ?Materials
    {
        return $this->materials_rental;
    }

    public function setMaterialsRental(?Materials $materials_rental): self
    {
        $this->materials_rental = $materials_rental;

        return $this;
    }

    public function getQuantityRental(): ?int
    {
        return $this->quantity_rental;
    }

    public function setQuantityRental(int $quantity_rental): self
    {
        $this->quantity_rental = $quantity_rental;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unit_price;
    }

    public function setUnitPrice(int $unit_price): self
    {
        $this->unit_price = $unit_price;

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

    public function getWorksiteRental(): ?Worksites
    {
        return $this->worksite_rental;
    }

    public function setWorksiteRental(?Worksites $worksite_rental): self
    {
        $this->worksite_rental = $worksite_rental;

        return $this;
    }

    public function getRepairRental(): ?Repairs
    {
        return $this->repair_rental;
    }

    public function setRepairRental(?Repairs $repair_rental): self
    {
        $this->repair_rental = $repair_rental;

        return $this;
    }
}
