<?php

namespace App\Entity;

use App\Repository\ContactsCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactsCategoriesRepository::class)]
class ContactsCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'contactsCategories', targetEntity: Contacts::class)]
    private Collection $contact;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Contacts>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact->add($contact);
            $contact->setContactsCategories($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getContactsCategories() === $this) {
                $contact->setContactsCategories(null);
            }
        }

        return $this;
    }
}
