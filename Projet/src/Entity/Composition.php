<?php

namespace App\Entity;

use App\Repository\CompositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompositionRepository::class)]
class Composition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_adult = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_child = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_animals = null;

    #[ORM\OneToMany(mappedBy: 'composition', targetEntity: Reservation::class)]
    private Collection $reserv;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix = null;

    public function __construct()
    {
        $this->reserv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnb_adult(): ?int
    {
        return $this->nb_adult;
    }

    public function setNbAdult(?int $nb_adult): self
    {
        $this->nb_adult = $nb_adult;

        return $this;
    }

    public function getnb_child(): ?int
    {
        return $this->nb_child;
    }

    public function setNbChild(?int $nb_child): self
    {
        $this->nb_child = $nb_child;

        return $this;
    }

    public function getnb_animals(): ?int
    {
        return $this->nb_animals;
    }

    public function setNbAnimals(?int $nb_animals): self
    {
        $this->nb_animals = $nb_animals;

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
            $reserv->setComposition($this);
        }

        return $this;
    }

    public function removeReserv(Reservation $reserv): self
    {
        if ($this->reserv->removeElement($reserv)) {
            // set the owning side to null (unless already changed)
            if ($reserv->getComposition() === $this) {
                $reserv->setComposition(null);
            }
        }

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
