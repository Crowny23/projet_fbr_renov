<?php

namespace App\Entity;

use App\Repository\DesignationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesignationRepository::class)]
class Designation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $unity = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price_unitary_ht = null;

    #[ORM\Column]
    private ?int $tva = null;

    #[ORM\ManyToOne(inversedBy: 'designations')]
    private ?Quotation $quotation = null;

    #[ORM\Column]
    private ?int $Price_ht = null;

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

    public function getUnity(): ?string
    {
        return $this->unity;
    }

    public function setUnity(string $unity): self
    {
        $this->unity = $unity;

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

    public function getPriceUnitaryHt(): ?int
    {
        return $this->price_unitary_ht;
    }

    public function setPriceUnitaryHt(int $price_unitary_ht): self
    {
        $this->price_unitary_ht = $price_unitary_ht;

        return $this;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getPriceHt(): ?int
    {
        return $this->Price_ht;
    }

    public function setPriceHt($quantity, $price_unitary_ht): self
    {
        $this->Price_ht = $price_unitary_ht * $quantity;

        return $this;
    }
}
