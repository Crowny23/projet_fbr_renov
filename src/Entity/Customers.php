<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomersRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Customers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $firstname = null;

    #[ORM\Column(length: 120)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $Town = null;

    #[ORM\Column]
    private ?int $postalcode = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $social_reason = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customer_note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    private ?Users $id_user = null;

    #[ORM\OneToMany(mappedBy: 'client_worksite', targetEntity: Worksites::class)]
    private Collection $worksite_customer;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Repairs::class)]
    private Collection $repairs;

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function __construct()
    {
        $this->worksite_customer = new ArrayCollection();
        $this->repairs = new ArrayCollection();
        $date = new DateTime();
        $timezone = new DateTimeZone('Europe/Paris');
        $this->createdAt = $date->setTimezone($timezone);
    }
    
    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $date = new DateTime();
        $timezone = new DateTimeZone('Europe/Paris');
        $this->updated_at = $date->setTimezone($timezone);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->Town;
    }

    public function setTown(string $Town): self
    {
        $this->Town = $Town;

        return $this;
    }

    public function getPostalcode(): ?int
    {
        return $this->postalcode;
    }

    public function setPostalcode(int $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->social_reason;
    }

    public function setSocialReason(string $social_reason): self
    {
        $this->social_reason = $social_reason;

        return $this;
    }

    public function getCustomerNote(): ?string
    {
        return $this->customer_note;
    }

    public function setCustomerNote(?string $customer_note): self
    {
        $this->customer_note = $customer_note;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->id_user;
    }

    public function setIdUser(?Users $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    
    /**
     * @return Collection<int, Worksites>
     */
    public function getWorksiteCustomer(): Collection
    {
        return $this->worksite_customer;
    }

    public function addWorksiteCustomer(Worksites $worksiteCustomer): self
    {
        if (!$this->worksite_customer->contains($worksiteCustomer)) {
            $this->worksite_customer->add($worksiteCustomer);
            $worksiteCustomer->setClientWorksite($this);
        }

        return $this;
    }

    public function removeWorksiteCustomer(Worksites $worksiteCustomer): self
    {
        if ($this->worksite_customer->removeElement($worksiteCustomer)) {
            // set the owning side to null (unless already changed)
            if ($worksiteCustomer->getClientWorksite() === $this) {
                $worksiteCustomer->setClientWorksite(null);
            }
        }

        return $this;
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
            $repair->setClient($this);
        }

        return $this;
    }

    public function removeRepair(Repairs $repair): self
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getClient() === $this) {
                $repair->setClient(null);
            }
        }

        return $this;
    }
}
