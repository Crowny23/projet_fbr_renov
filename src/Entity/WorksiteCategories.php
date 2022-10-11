<?php

namespace App\Entity;

use App\Repository\WorksiteCategoriesRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorksiteCategoriesRepository::class)]
#[ORM\HasLifecycleCallbacks]

class WorksiteCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_worksite_categories = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function __toString()
    {
        return $this->name_worksite_categories;
    }

    public function __construct()
    {
        
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

    public function getNameWorksiteCategories(): ?string
    {
        return $this->name_worksite_categories;
    }

    public function setNameWorksiteCategories(string $name_worksite_categories): self
    {
        $this->name_worksite_categories = $name_worksite_categories;

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
        $timezone = new \DateTimeZone('Europe/Paris');
        $updated_at->setTimezone($timezone);
        
        $this->updated_at = $updated_at;

        return $this;
    }
}
