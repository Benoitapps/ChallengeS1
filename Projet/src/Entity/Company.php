<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Reservation::class)]
    private Collection $reserv;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'companies')]
    private Collection $countrys;

    public function __construct()
    {
        $this->reserv = new ArrayCollection();
        $this->countrys = new ArrayCollection();
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
     * @return Collection<int, Reservation>
     */
    public function getReserv(): Collection
    {
        return $this->reserv;
    }

    public function addReserv(Reservation $reserv): self
    {
        if (!$this->reserv->contains($reserv)) {
            $this->reserv->add($reserv);
            $reserv->setCompany($this);
        }

        return $this;
    }

    public function removeReserv(Reservation $reserv): self
    {
        if ($this->reserv->removeElement($reserv)) {
            // set the owning side to null (unless already changed)
            if ($reserv->getCompany() === $this) {
                $reserv->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountrys(): Collection
    {
        return $this->countrys;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countrys->contains($country)) {
            $this->countrys->add($country);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        $this->countrys->removeElement($country);

        return $this;
    }
}
