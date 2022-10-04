<?php

namespace App\Entity;

use App\Repository\WorksitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorksitesRepository::class)]
class Worksites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_worksite = null;

    #[ORM\Column(length: 255)]
    private ?string $city_worksite = null;

    #[ORM\Column]
    private ?int $cp_worksite = null;

    #[ORM\Column(length: 255)]
    private ?string $adress_worksite = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $start_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $duration_worksite = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supplement_worksite = null;

    #[ORM\Column]
    private ?int $travel_distance_worksite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note_client_worksite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note_admin_worksite = null;

    #[ORM\Column]
    private ?bool $is_urgent = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorksiteCategories $category_worksite = null;

    #[ORM\Column(length: 255)]
    private ?string $status_worksite = null;

    #[ORM\ManyToMany(targetEntity: WorksiteImages::class, mappedBy: 'worksite')]
    private Collection $images_worksite;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'worksite', targetEntity: Tasks::class)]
    private Collection $task_worksite;

    #[ORM\OneToOne(mappedBy: 'worksite', cascade: ['persist', 'remove'])]
    private ?Quotation $quotation_worksite = null;

    #[ORM\OneToMany(mappedBy: 'worksite_rental', targetEntity: Rentals::class)]
    private Collection $rental_worksite;

    #[ORM\OneToMany(mappedBy: 'worksite', targetEntity: WorksiteImages::class)]
    private Collection $image_worksite;

    public function __construct()
    {
        $this->images_worksite = new ArrayCollection();
        $this->task_worksite = new ArrayCollection();
        $this->rental_worksite = new ArrayCollection();
        $this->image_worksite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameWorksite(): ?string
    {
        return $this->name_worksite;
    }

    public function setNameWorksite(string $name_worksite): self
    {
        $this->name_worksite = $name_worksite;

        return $this;
    }

    public function getCityWorksite(): ?string
    {
        return $this->city_worksite;
    }

    public function setCityWorksite(string $city_worksite): self
    {
        $this->city_worksite = $city_worksite;

        return $this;
    }

    public function getCpWorksite(): ?int
    {
        return $this->cp_worksite;
    }

    public function setCpWorksite(int $cp_worksite): self
    {
        $this->cp_worksite = $cp_worksite;

        return $this;
    }

    public function getAdressWorksite(): ?string
    {
        return $this->adress_worksite;
    }

    public function setAdressWorksite(string $adress_worksite): self
    {
        $this->adress_worksite = $adress_worksite;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeImmutable $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getDurationWorksite(): ?\DateTimeInterface
    {
        return $this->duration_worksite;
    }

    public function setDurationWorksite(\DateTimeInterface $duration_worksite): self
    {
        $this->duration_worksite = $duration_worksite;

        return $this;
    }

    public function getSupplementWorksite(): ?\DateTimeInterface
    {
        return $this->supplement_worksite;
    }

    public function setSupplementWorksite(?\DateTimeInterface $supplement_worksite): self
    {
        $this->supplement_worksite = $supplement_worksite;

        return $this;
    }

    public function getTravelDistanceWorksite(): ?int
    {
        return $this->travel_distance_worksite;
    }

    public function setTravelDistanceWorksite(int $travel_distance_worksite): self
    {
        $this->travel_distance_worksite = $travel_distance_worksite;

        return $this;
    }

    public function getNoteClientWorksite(): ?string
    {
        return $this->note_client_worksite;
    }

    public function setNoteClientWorksite(?string $note_client_worksite): self
    {
        $this->note_client_worksite = $note_client_worksite;

        return $this;
    }

    public function getNoteAdminWorksite(): ?string
    {
        return $this->note_admin_worksite;
    }

    public function setNoteAdminWorksite(?string $note_admin_worksite): self
    {
        $this->note_admin_worksite = $note_admin_worksite;

        return $this;
    }

    public function isIsUrgent(): ?bool
    {
        return $this->is_urgent;
    }

    public function setIsUrgent(bool $is_urgent): self
    {
        $this->is_urgent = $is_urgent;

        return $this;
    }

    public function getCategoryWorksite(): ?WorksiteCategories
    {
        return $this->category_worksite;
    }

    public function setCategoryWorksite(?WorksiteCategories $category_worksite): self
    {
        $this->category_worksite = $category_worksite;

        return $this;
    }

    public function getStatusWorksite(): ?string
    {
        return $this->status_worksite;
    }

    public function setStatusWorksite(string $status_worksite): self
    {
        $this->status_worksite = $status_worksite;

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
     * @return Collection<int, WorksiteImages>
     */
    public function getImagesWorksite(): Collection
    {
        return $this->images_worksite;
    }

    public function addImagesWorksite(WorksiteImages $imagesWorksite): self
    {
        if (!$this->images_worksite->contains($imagesWorksite)) {
            $this->images_worksite->add($imagesWorksite);
            $imagesWorksite->addWorksite($this);
        }

        return $this;
    }

    public function removeImagesWorksite(WorksiteImages $imagesWorksite): self
    {
        if ($this->images_worksite->removeElement($imagesWorksite)) {
            $imagesWorksite->removeWorksite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTaskWorksite(): Collection
    {
        return $this->task_worksite;
    }

    public function addTaskWorksite(Tasks $taskWorksite): self
    {
        if (!$this->task_worksite->contains($taskWorksite)) {
            $this->task_worksite->add($taskWorksite);
            $taskWorksite->setWorksite($this);
        }

        return $this;
    }

    public function removeTaskWorksite(Tasks $taskWorksite): self
    {
        if ($this->task_worksite->removeElement($taskWorksite)) {
            // set the owning side to null (unless already changed)
            if ($taskWorksite->getWorksite() === $this) {
                $taskWorksite->setWorksite(null);
            }
        }

        return $this;
    }

    public function getQuotationWorksite(): ?Quotation
    {
        return $this->quotation_worksite;
    }

    public function setQuotationWorksite(Quotation $quotation_worksite): self
    {
        // set the owning side of the relation if necessary
        if ($quotation_worksite->getWorksite() !== $this) {
            $quotation_worksite->setWorksite($this);
        }

        $this->quotation_worksite = $quotation_worksite;

        return $this;
    }

    /**
     * @return Collection<int, Rentals>
     */
    public function getRentalWorksite(): Collection
    {
        return $this->rental_worksite;
    }

    public function addRentalWorksite(Rentals $rentalWorksite): self
    {
        if (!$this->rental_worksite->contains($rentalWorksite)) {
            $this->rental_worksite->add($rentalWorksite);
            $rentalWorksite->setWorksiteRental($this);
        }

        return $this;
    }

    public function removeRentalWorksite(Rentals $rentalWorksite): self
    {
        if ($this->rental_worksite->removeElement($rentalWorksite)) {
            // set the owning side to null (unless already changed)
            if ($rentalWorksite->getWorksiteRental() === $this) {
                $rentalWorksite->setWorksiteRental(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorksiteImages>
     */
    public function getImageWorksite(): Collection
    {
        return $this->image_worksite;
    }

    public function addImageWorksite(WorksiteImages $imageWorksite): self
    {
        if (!$this->image_worksite->contains($imageWorksite)) {
            $this->image_worksite->add($imageWorksite);
            $imageWorksite->setWorksite($this);
        }

        return $this;
    }

    public function removeImageWorksite(WorksiteImages $imageWorksite): self
    {
        if ($this->image_worksite->removeElement($imageWorksite)) {
            // set the owning side to null (unless already changed)
            if ($imageWorksite->getWorksite() === $this) {
                $imageWorksite->setWorksite(null);
            }
        }

        return $this;
    }
}
