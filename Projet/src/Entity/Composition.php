<?php

namespace App\Entity;

use App\Repository\CompositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function __construct()
    {
        $this->reserv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbAdult(): ?int
    {
        return $this->nb_adult;
    }

    public function setNbAdult(?int $nb_adult): self
    {
        $this->nb_adult = $nb_adult;

        return $this;
    }

    public function getNbChild(): ?int
    {
        return $this->nb_child;
    }

    public function setNbChild(?int $nb_child): self
    {
        $this->nb_child = $nb_child;

        return $this;
    }

    public function getNbAnimals(): ?int
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
}
