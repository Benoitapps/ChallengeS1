<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(mappedBy: 'country', targetEntity: Reservation::class)]
    private Collection $reserv;

    #[ORM\ManyToMany(targetEntity: Company::class, mappedBy: 'countrys')]
    private Collection $companies;

    public function __construct()
    {
        $this->reserv = new ArrayCollection();
        $this->companies = new ArrayCollection();
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
            $reserv->setCountry($this);
        }

        return $this;
    }

    public function removeReserv(Reservation $reserv): self
    {
        if ($this->reserv->removeElement($reserv)) {
            // set the owning side to null (unless already changed)
            if ($reserv->getCountry() === $this) {
                $reserv->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addCountry($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            $company->removeCountry($this);
        }

        return $this;
    }
}
