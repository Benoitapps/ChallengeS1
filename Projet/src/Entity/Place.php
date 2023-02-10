<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb = null;

    #[ORM\ManyToOne(inversedBy: 'placesUser')]
    private ?User $acheteur = null;

    #[ORM\ManyToOne(inversedBy: 'placesReserv')]
    private ?Annonce $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(?int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    public function getAcheteur(): ?User
    {
        return $this->acheteur;
    }

    public function setAcheteur(?User $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    public function getReservation(): ?Annonce
    {
        return $this->reservation;
    }

    public function setReservation(?Annonce $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
