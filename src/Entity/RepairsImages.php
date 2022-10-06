<?php

namespace App\Entity;

use App\Repository\RepairsImagesRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepairsImagesRepository::class)]
class RepairsImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_repairs_images = null;

    #[ORM\ManyToOne(inversedBy: 'image_repair')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Repairs $repair = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageRepairsImages(): ?string
    {
        return $this->image_repairs_images;
    }

    public function setImageRepairsImages(string $image_repairs_images): self
    {
        $this->image_repairs_images = $image_repairs_images;

        return $this;
    }

    public function getRepair(): ?Repairs
    {
        return $this->repair;
    }

    public function setRepair(?Repairs $repair): self
    {
        $this->repair = $repair;

        return $this;
    }
}
