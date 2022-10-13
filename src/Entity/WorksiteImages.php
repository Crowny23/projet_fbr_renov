<?php

namespace App\Entity;

use App\Repository\WorksiteImagesRepository;
use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: WorksiteImagesRepository::class)]
class WorksiteImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: "worksites", fileNameProperty: "image_worksite_images", size: "imageSize")]
    private ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_worksite_images = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'image_worksite')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Worksites $worksite = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageWorksiteImages(): ?string
    {
        return $this->image_worksite_images;
    }

    public function setImageWorksiteImages(?string $image_worksite_images): self
    {
        $this->image_worksite_images = $image_worksite_images;

        return $this;
    }

    public function getWorksite(): ?Worksites
    {
        return $this->worksite;
    }

    public function setWorksite(?Worksites $worksite): self
    {
        $this->worksite = $worksite;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            $this->updated_at = $date->setTimezone($timezone);
        }

        return $this;
    }
}
