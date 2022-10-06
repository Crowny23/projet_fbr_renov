<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use DateTimeImmutable;
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
    private ?int $price_quotation = null;

    #[ORM\Column(length: 255)]
    private ?string $status_quotation = null;

    #[ORM\Column]
    private ?int $deposit_quotation = null;

    #[ORM\Column]
    private ?int $intermediate_payment_quotation = null;

    #[ORM\Column]
    private ?int $final_payment_quotation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
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

    public function getPriceQuotation(): ?int
    {
        return $this->price_quotation;
    }

    public function setPriceQuotation(int $price_quotation): self
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

    public function getDepositQuotation(): ?int
    {
        return $this->deposit_quotation;
    }

    public function setDepositQuotation(int $deposit_quotation): self
    {
        $this->deposit_quotation = $deposit_quotation;

        return $this;
    }

    public function getIntermediatePaymentQuotation(): ?int
    {
        return $this->intermediate_payment_quotation;
    }

    public function setIntermediatePaymentQuotation(?int $intermediate_payment_quotation): self
    {
        $this->intermediate_payment_quotation = $intermediate_payment_quotation;

        return $this;
    }

    public function getFinalPaymentQuotation(): ?int
    {
        return $this->final_payment_quotation;
    }

    public function setFinalPaymentQuotation(int $final_payment_quotation): self
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
}
