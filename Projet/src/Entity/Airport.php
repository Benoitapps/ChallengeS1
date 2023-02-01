<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'airports')]
    private ?City $city = null;

    #[ORM\OneToMany(mappedBy: 'airportDepartAller', targetEntity: Annonce::class)]
    private Collection $annoncesDepartAirport;

    #[ORM\OneToMany(mappedBy: 'airportDepartArriver', targetEntity: Annonce::class)]
    private Collection $annoncesAirportDepartArriver;

    #[ORM\OneToMany(mappedBy: 'airportRetourAller', targetEntity: Annonce::class)]
    private Collection $annoncesAirportRetourAller;

    #[ORM\OneToMany(mappedBy: 'airportRetourArriver', targetEntity: Annonce::class)]
    private Collection $annoncesAirportRetourArriver;

    public function __construct()
    {
        $this->annoncesDepartAirport = new ArrayCollection();
        $this->annoncesAirportDepartArriver = new ArrayCollection();
        $this->annoncesAirportRetourAller = new ArrayCollection();
        $this->annoncesAirportRetourArriver = new ArrayCollection();
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesDepartAirport(): Collection
    {
        return $this->annoncesDepartAirport;
    }

    public function addAnnoncesDepartAirport(Annonce $annoncesDepartAirport): self
    {
        if (!$this->annoncesDepartAirport->contains($annoncesDepartAirport)) {
            $this->annoncesDepartAirport->add($annoncesDepartAirport);
            $annoncesDepartAirport->setAirportDepartAller($this);
        }

        return $this;
    }

    public function removeAnnoncesDepartAirport(Annonce $annoncesDepartAirport): self
    {
        if ($this->annoncesDepartAirport->removeElement($annoncesDepartAirport)) {
            // set the owning side to null (unless already changed)
            if ($annoncesDepartAirport->getAirportDepartAller() === $this) {
                $annoncesDepartAirport->setAirportDepartAller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesAirportDepartArriver(): Collection
    {
        return $this->annoncesAirportDepartArriver;
    }

    public function addAnnoncesAirportDepartArriver(Annonce $annoncesAirportDepartArriver): self
    {
        if (!$this->annoncesAirportDepartArriver->contains($annoncesAirportDepartArriver)) {
            $this->annoncesAirportDepartArriver->add($annoncesAirportDepartArriver);
            $annoncesAirportDepartArriver->setAirportDepartArriver($this);
        }

        return $this;
    }

    public function removeAnnoncesAirportDepartArriver(Annonce $annoncesAirportDepartArriver): self
    {
        if ($this->annoncesAirportDepartArriver->removeElement($annoncesAirportDepartArriver)) {
            // set the owning side to null (unless already changed)
            if ($annoncesAirportDepartArriver->getAirportDepartArriver() === $this) {
                $annoncesAirportDepartArriver->setAirportDepartArriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesAirportRetourAller(): Collection
    {
        return $this->annoncesAirportRetourAller;
    }

    public function addAnnoncesAirportRetourAller(Annonce $annoncesAirportRetourAller): self
    {
        if (!$this->annoncesAirportRetourAller->contains($annoncesAirportRetourAller)) {
            $this->annoncesAirportRetourAller->add($annoncesAirportRetourAller);
            $annoncesAirportRetourAller->setAirportRetourAller($this);
        }

        return $this;
    }

    public function removeAnnoncesAirportRetourAller(Annonce $annoncesAirportRetourAller): self
    {
        if ($this->annoncesAirportRetourAller->removeElement($annoncesAirportRetourAller)) {
            // set the owning side to null (unless already changed)
            if ($annoncesAirportRetourAller->getAirportRetourAller() === $this) {
                $annoncesAirportRetourAller->setAirportRetourAller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesAirportRetourArriver(): Collection
    {
        return $this->annoncesAirportRetourArriver;
    }

    public function addAnnoncesAirportRetourArriver(Annonce $annoncesAirportRetourArriver): self
    {
        if (!$this->annoncesAirportRetourArriver->contains($annoncesAirportRetourArriver)) {
            $this->annoncesAirportRetourArriver->add($annoncesAirportRetourArriver);
            $annoncesAirportRetourArriver->setAirportRetourArriver($this);
        }

        return $this;
    }

    public function removeAnnoncesAirportRetourArriver(Annonce $annoncesAirportRetourArriver): self
    {
        if ($this->annoncesAirportRetourArriver->removeElement($annoncesAirportRetourArriver)) {
            // set the owning side to null (unless already changed)
            if ($annoncesAirportRetourArriver->getAirportRetourArriver() === $this) {
                $annoncesAirportRetourArriver->setAirportRetourArriver(null);
            }
        }

        return $this;
    }
}
