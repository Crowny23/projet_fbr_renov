<?php

namespace App\Entity;

use App\Repository\RepairsRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepairsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Repairs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_repair = null;

    #[ORM\Column(length: 255)]
    private ?string $city_repair = null;

    #[ORM\Column]
    private ?int $cp_repair = null;

    #[ORM\Column(length: 255)]
    private ?string $adress_repair = null;

    #[ORM\Column]
    private ?int $price_repair = null;

    #[ORM\Column]
    private ?int $reference_repair = null;

    #[ORM\Column(length: 255)]
    private ?string $schedule_repair = null;

    #[ORM\Column]
    private ?int $travel_distance_repair = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note_admin_repair = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'repair_rental', targetEntity: Rentals::class)]
    private Collection $rental_repair;

    #[ORM\OneToMany(mappedBy: 'repair', targetEntity: RepairsImages::class)]
    private Collection $image_repair;


    public function __toString()
    {
        return $this->name_repair;
    }

    #[ORM\ManyToOne(inversedBy: 'repairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customers $client = null;

    #[ORM\ManyToOne(inversedBy: 'repairs')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?RepairsCategories $category = null;


    public function __construct()
    {
        $this->rental_repair = new ArrayCollection();
        $this->image_repair = new ArrayCollection();

        $date = new DateTimeImmutable();
        $timezone = new DateTimeZone('Europe/Paris');
        $this->created_at = $date->setTimezone($timezone);
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $date = new DateTimeImmutable();
        $timezone = new DateTimeZone('Europe/Paris');
        $this->updated_at = $date->setTimezone($timezone);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRepair(): ?string
    {
        return $this->name_repair;
    }

    public function setNameRepair(string $name_repair): self
    {
        $this->name_repair = $name_repair;

        return $this;
    }

    public function getCityRepair(): ?string
    {
        return $this->city_repair;
    }

    public function setCityRepair(string $city_repair): self
    {
        $this->city_repair = $city_repair;

        return $this;
    }

    public function getCpRepair(): ?int
    {
        return $this->cp_repair;
    }

    public function setCpRepair(int $cp_repair): self
    {
        $this->cp_repair = $cp_repair;

        return $this;
    }

    public function getAdressRepair(): ?string
    {
        return $this->adress_repair;
    }

    public function setAdressRepair(string $adress_repair): self
    {
        $this->adress_repair = $adress_repair;

        return $this;
    }

    public function getPriceRepair(): ?int
    {
        return $this->price_repair;
    }

    public function setPriceRepair(int $price_repair): self
    {
        $this->price_repair = $price_repair;

        return $this;
    }

    public function getReferenceRepair(): ?int
    {
        return $this->reference_repair;
    }

    public function setReferenceRepair(int $reference_repair): self
    {
        $this->reference_repair = $reference_repair;

        return $this;
    }

    public function getScheduleRepair(): ?string
    {
        return $this->schedule_repair;
    }

    public function setScheduleRepair(string $schedule_repair): self
    {
        $this->schedule_repair = $schedule_repair;

        return $this;
    }

    public function getTravelDistanceRepair(): ?int
    {
        return $this->travel_distance_repair;
    }

    public function setTravelDistanceRepair(int $travel_distance_repair): self
    {
        $this->travel_distance_repair = $travel_distance_repair;

        return $this;
    }

    public function getNoteAdminRepair(): ?string
    {
        return $this->note_admin_repair;
    }

    public function setNoteAdminRepair(?string $note_admin_repair): self
    {
        $this->note_admin_repair = $note_admin_repair;

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
    public function getRentalRepair(): Collection
    {
        return $this->rental_repair;
    }

    public function addRentalRepair(Rentals $rentalRepair): self
    {
        if (!$this->rental_repair->contains($rentalRepair)) {
            $this->rental_repair->add($rentalRepair);
            $rentalRepair->setRepairRental($this);
        }

        return $this;
    }

    public function removeRentalRepair(Rentals $rentalRepair): self
    {
        if ($this->rental_repair->removeElement($rentalRepair)) {
            // set the owning side to null (unless already changed)
            if ($rentalRepair->getRepairRental() === $this) {
                $rentalRepair->setRepairRental(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RepairsImages>
     */
    public function getImageRepair(): Collection
    {
        return $this->image_repair;
    }

    public function addImageRepair(RepairsImages $imageRepair): self
    {
        if (!$this->image_repair->contains($imageRepair)) {
            $this->image_repair->add($imageRepair);
            $imageRepair->setRepair($this);
        }

        return $this;
    }

    public function removeImageRepair(RepairsImages $imageRepair): self
    {
        if ($this->image_repair->removeElement($imageRepair)) {
            // set the owning side to null (unless already changed)
            if ($imageRepair->getRepair() === $this) {
                $imageRepair->setRepair(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Customers
    {
        return $this->client;
    }

    public function setClient(?Customers $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCategory(): ?RepairsCategories
    {
        return $this->category;
    }

    public function setCategory(?RepairsCategories $category): self
    {
        $this->category = $category;

        return $this;
    }
}
