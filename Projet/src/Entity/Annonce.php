<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
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

    #[ORM\ManyToOne(inversedBy: 'annoncesDepartAller')]
    private ?Date $dateDepartAller = null;

    #[ORM\ManyToOne(inversedBy: 'annonceDepartArriver')]
    private ?Date $dateDepartArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesDepartAirport')]
    private ?Airport $airportDepartAller = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportDepartArriver')]
    private ?Airport $airportDepartArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesDateRetourAller')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Date $dateRetourAller = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesDateRetourArriver')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Date $dateRetourArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportRetourAller')]
    private ?Airport $airportRetourAller = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesAirportRetourArriver')]
    private ?Airport $airportRetourArriver = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesCompo')]
    private ?Composition $composition = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesUser')]
    private ?User $client = null;

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

    public function getDateDepartAller(): ?Date
    {
        return $this->dateDepartAller;
    }

    public function setDateDepartAller(?Date $dateDepartAller): self
    {
        $this->dateDepartAller = $dateDepartAller;

        return $this;
    }

    public function getDateDepartArriver(): ?Date
    {
        return $this->dateDepartArriver;
    }

    public function setDateDepartArriver(?Date $dateDepartArriver): self
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

    public function getDateRetourAller(): ?Date
    {
        return $this->dateRetourAller;
    }

    public function setDateRetourAller(?Date $dateRetourAller): self
    {
        $this->dateRetourAller = $dateRetourAller;

        return $this;
    }

    public function getDateRetourArriver(): ?Date
    {
        return $this->dateRetourArriver;
    }

    public function setDateRetourArriver(?Date $dateRetourArriver): self
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

    public function getComposition(): ?Composition
    {
        return $this->composition;
    }

    public function setComposition(?Composition $composition): self
    {
        $this->composition = $composition;

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
}
