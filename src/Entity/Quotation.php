<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotationRepository::class)]
class Quotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'quotation_worksite', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Worksites $worksite = null;

    #[ORM\Column(length: 255)]
    private ?string $reference_quotation = null;

    #[ORM\Column]
    private ?float $price_quotation = null;

    #[ORM\Column(length: 255)]
    private ?string $status_quotation = null;

    #[ORM\Column]
    private ?float $deposit_quotation = null;

    #[ORM\Column]
    private ?float $intermediate_payment_quotation = null;

    #[ORM\Column]
    private ?float $final_payment_quotation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $object = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: Designation::class)]
    private Collection $designations;

    #[ORM\Column(nullable: true)]
    private ?float $second_deposit = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    public function __toString()
    {
        return $this->object;
    }

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->designations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->reference_quotation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorksite(): ?Worksites
    {
        return $this->worksite;
    }

    public function setWorksite(Worksites $worksite): self
    {
        $this->worksite = $worksite;

        return $this;
    }

    public function getReferenceQuotation(): ?string
    {
        return $this->reference_quotation;
    }

    public function setReferenceQuotation(string $reference_quotation): self
    {
        $this->reference_quotation = $reference_quotation;

        return $this;
    }

    public function getPriceQuotation(): ?float
    {
        return $this->price_quotation;
    }

    public function setPriceQuotation(float $price_quotation): self
    {
        $this->price_quotation = $price_quotation;

        return $this;
    }

    public function getStatusQuotation(): ?string
    {
        return $this->status_quotation;
    }

    public function setStatusQuotation(string $status_quotation): self
    {
        $this->status_quotation = $status_quotation;

        return $this;
    }

    public function getDepositQuotation(): ?float
    {
        return $this->deposit_quotation;
    }

    public function setDepositQuotation(float $deposit_quotation): self
    {
        $this->deposit_quotation = $deposit_quotation;

        return $this;
    }

    public function getIntermediatePaymentQuotation(): ?float
    {
        return $this->intermediate_payment_quotation;
    }

    public function setIntermediatePaymentQuotation(?float $intermediate_payment_quotation): self
    {
        $this->intermediate_payment_quotation = $intermediate_payment_quotation;

        return $this;
    }

    public function getFinalPaymentQuotation(): ?float
    {
        return $this->final_payment_quotation;
    }

    public function setFinalPaymentQuotation(float $final_payment_quotation): self
    {
        $this->final_payment_quotation = $final_payment_quotation;

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

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return Collection<int, Designation>
     */
    public function getDesignations(): Collection
    {
        return $this->designations;
    }

    public function addDesignation(Designation $designation): self
    {
        if (!$this->designations->contains($designation)) {
            $this->designations->add($designation);
            $designation->setQuotation($this);
        }

        return $this;
    }

    public function removeDesignation(Designation $designation): self
    {
        if ($this->designations->removeElement($designation)) {
            // set the owning side to null (unless already changed)
            if ($designation->getQuotation() === $this) {
                $designation->setQuotation(null);
            }
        }

        return $this;
    }

    public function getSecondDeposit(): ?float
    {
        return $this->second_deposit;
    }

    public function setSecondDeposit(?float $second_deposit): self
    {
        $this->second_deposit = $second_deposit;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
