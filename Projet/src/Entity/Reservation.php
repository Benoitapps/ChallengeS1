<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $by = null;

    #[ORM\ManyToMany(targetEntity: Date::class, mappedBy: 'reserv')]
    private Collection $dates;

    #[ORM\ManyToOne(inversedBy: 'reserv')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Composition $composition = null;

    #[ORM\ManyToOne(inversedBy: 'reserv')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'reserv')]
    private ?Company $company = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix = null;

    public function __construct()
    {
        $this->dates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBy(): ?User
    {
        return $this->by;
    }

    public function setBy(?User $by): self
    {
        $this->by = $by;

        return $this;
    }

    /**
     * @return Collection<int, Date>
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(Date $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates->add($date);
            $date->addReserv($this);
        }

        return $this;
    }

    public function removeDate(Date $date): self
    {
        if ($this->dates->removeElement($date)) {
            $date->removeReserv($this);
        }

        return $this;
    }

    public function getComposition(): ?Composition
    {
        return $this->composition;
    }

    public function setComposition(?Composition $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
