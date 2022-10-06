<?php

namespace App\Entity;

use App\Repository\RenterRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenterRepository::class)]
class Renter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_renter = null;

    #[ORM\Column(length: 255)]
    private ?string $city_renter = null;

    #[ORM\Column]
    private ?int $cp_renter = null;

    #[ORM\Column(length: 255)]
    private ?string $adress_renter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website_renter = null;

    #[ORM\Column(length: 255)]
    private ?string $email_renter = null;

    #[ORM\Column]
    private ?int $phone_renter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note_admin_renter = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'renter_rentals', targetEntity: Rentals::class)]
    private Collection $rentals_renter;

    public function __construct()
    {
        $this->rentals_renter = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRenter(): ?string
    {
        return $this->name_renter;
    }

    public function setNameRenter(string $name_renter): self
    {
        $this->name_renter = $name_renter;

        return $this;
    }

    public function getCityRenter(): ?string
    {
        return $this->city_renter;
    }

    public function setCityRenter(string $city_renter): self
    {
        $this->city_renter = $city_renter;

        return $this;
    }

    public function getCpRenter(): ?int
    {
        return $this->cp_renter;
    }

    public function setCpRenter(int $cp_renter): self
    {
        $this->cp_renter = $cp_renter;

        return $this;
    }

    public function getAdressRenter(): ?string
    {
        return $this->adress_renter;
    }

    public function setAdressRenter(string $adress_renter): self
    {
        $this->adress_renter = $adress_renter;

        return $this;
    }

    public function getWebsiteRenter(): ?string
    {
        return $this->website_renter;
    }

    public function setWebsiteRenter(string $website_renter): self
    {
        $this->website_renter = $website_renter;

        return $this;
    }

    public function getEmailRenter(): ?string
    {
        return $this->email_renter;
    }

    public function setEmailRenter(string $email_renter): self
    {
        $this->email_renter = $email_renter;

        return $this;
    }

    public function getPhoneRenter(): ?int
    {
        return $this->phone_renter;
    }

    public function setPhoneRenter(int $phone_renter): self
    {
        $this->phone_renter = $phone_renter;

        return $this;
    }

    public function getNoteAdminRenter(): ?string
    {
        return $this->note_admin_renter;
    }

    public function setNoteAdminRenter(?string $note_admin_renter): self
    {
        $this->note_admin_renter = $note_admin_renter;

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
    public function getRentalsRenter(): Collection
    {
        return $this->rentals_renter;
    }

    public function addRentalsRenter(Rentals $rentalsRenter): self
    {
        if (!$this->rentals_renter->contains($rentalsRenter)) {
            $this->rentals_renter->add($rentalsRenter);
            $rentalsRenter->setRenterRentals($this);
        }

        return $this;
    }

    public function removeRentalsRenter(Rentals $rentalsRenter): self
    {
        if ($this->rentals_renter->removeElement($rentalsRenter)) {
            // set the owning side to null (unless already changed)
            if ($rentalsRenter->getRenterRentals() === $this) {
                $rentalsRenter->setRenterRentals(null);
            }
        }

        return $this;
    }
}
