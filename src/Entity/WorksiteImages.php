<?php

namespace App\Entity;

use App\Repository\WorksiteImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorksiteImagesRepository::class)]
class WorksiteImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_worksite_images = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'image_worksite')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Worksites $worksite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageWorksiteImages(): ?string
    {
        return $this->image_worksite_images;
    }

    public function setImageWorksiteImages(string $image_worksite_images): self
    {
        $this->image_worksite_images = $image_worksite_images;

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

    public function getWorksite(): ?Worksites
    {
        return $this->worksite;
    }

    public function setWorksite(?Worksites $worksite): self
    {
        $this->worksite = $worksite;

        return $this;
    }
}
