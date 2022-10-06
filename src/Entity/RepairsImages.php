<?php

namespace App\Entity;

use App\Repository\RepairsImagesRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: RepairsImagesRepository::class)]
class RepairsImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: "repairs", fileNameProperty: "image_repairs_images", size: "imageSize")]
    private ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_repairs_images = null;

    #[ORM\ManyToOne(inversedBy: 'image_repair')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?Repairs $repair = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageRepairsImages(): ?string
    {
        return $this->image_repairs_images;
    }

    public function setImageRepairsImages(?string $image_repairs_images): self
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


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        if ($file instanceof UploadedFile)
        {
            $date = new DateTime();
            $timezone = new DateTimeZone('Europe/Paris');
            $this->updatedAt = $date->setTimezone($timezone);
        }

        return $this;
    }
}
