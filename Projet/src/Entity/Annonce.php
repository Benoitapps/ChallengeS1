<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDepartAller = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDepartArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesDepartAirport')]
    private ?Airport $airportDepartAller = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportDepartArriver')]
    private ?Airport $airportDepartArriver = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRetourAller = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRetourArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportRetourAller')]
    private ?Airport $airportRetourAller = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportRetourArriver')]
    private ?Airport $airportRetourArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesUser')]
    private ?User $client = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesCreator')]
    private ?User $creator = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pay = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'annoncesBuyer')]
    private Collection $buyer;

    #[ORM\Column(nullable: true)]
    private ?int $place = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Place::class)]
    private Collection $placesReserv;

    public function __construct()
    {
        $this->buyer = new ArrayCollection();
        $this->placesReserv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateDepartAller(): ?\DateTimeInterface
    {
        return $this->dateDepartAller;
    }

    public function setDateDepartAller(\DateTimeInterface $dateDepartAller): self
    {
        $this->dateDepartAller = $dateDepartAller;

        return $this;
    }

    public function getDateDepartArriver(): ?\DateTimeInterface
    {
        return $this->dateDepartArriver;
    }

    public function setDateDepartArriver(\DateTimeInterface $dateDepartArriver): self
    {
        $this->dateDepartArriver = $dateDepartArriver;

        return $this;
    }

    public function getAirportDepartAller(): ?Airport
    {
        return $this->airportDepartAller;
    }

    public function setAirportDepartAller(?Airport $airportDepartAller): self
    {
        $this->airportDepartAller = $airportDepartAller;

        return $this;
    }

    public function getAirportDepartArriver(): ?Airport
    {
        return $this->airportDepartArriver;
    }

    public function setAirportDepartArriver(?Airport $airportDepartArriver): self
    {
        $this->airportDepartArriver = $airportDepartArriver;

        return $this;
    }

    public function getDateRetourAller(): ?\DateTimeInterface
    {
        return $this->dateRetourAller;
    }

    public function setDateRetourAller(\DateTimeInterface $dateRetourAller): self
    {
        $this->dateRetourAller = $dateRetourAller;

        return $this;
    }

    public function getDateRetourArriver(): ?\DateTimeInterface
    {
        return $this->dateRetourArriver;
    }

    public function setDateRetourArriver(\DateTimeInterface $dateRetourArriver): self
    {
        $this->dateRetourArriver = $dateRetourArriver;

        return $this;
    }

    public function getAirportRetourAller(): ?Airport
    {
        return $this->airportRetourAller;
    }

    public function setAirportRetourAller(?Airport $airportRetourAller): self
    {
        $this->airportRetourAller = $airportRetourAller;

        return $this;
    }

    public function getAirportRetourArriver(): ?Airport
    {
        return $this->airportRetourArriver;
    }

    public function setAirportRetourArriver(?Airport $airportRetourArriver): self
    {
        $this->airportRetourArriver = $airportRetourArriver;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function isPay(): ?bool
    {
        return $this->pay;
    }

    public function setPay(?bool $pay): self
    {
        $this->pay = $pay;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getBuyer(): Collection
    {
        return $this->buyer;
    }

    public function addBuyer(User $buyer): self
    {
        if (!$this->buyer->contains($buyer)) {
            $this->buyer->add($buyer);
        }

        return $this;
    }

    public function removeBuyer(User $buyer): self
    {
        $this->buyer->removeElement($buyer);

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(?int $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlacesReserv(): Collection
    {
        return $this->placesReserv;
    }

    public function addPlacesReserv(Place $placesReserv): self
    {
        if (!$this->placesReserv->contains($placesReserv)) {
            $this->placesReserv->add($placesReserv);
            $placesReserv->setReservation($this);
        }

        return $this;
    }

    public function removePlacesReserv(Place $placesReserv): self
    {
        if ($this->placesReserv->removeElement($placesReserv)) {
            // set the owning side to null (unless already changed)
            if ($placesReserv->getReservation() === $this) {
                $placesReserv->setReservation(null);
            }
        }

        return $this;
    }
}
