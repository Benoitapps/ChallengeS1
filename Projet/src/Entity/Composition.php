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
    private ?int $nbAdult = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbChild = null;

    #[ORM\OneToMany(mappedBy: 'composition', targetEntity: Annonce::class)]
    private Collection $annoncesCompo;

    public function __construct()
    {
        $this->annoncesCompo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbAdult(): ?int
    {
        return $this->nbAdult;
    }

    public function getnb_adult(): ?int
    {
        return $this->nbAdult;
    }

    public function setNbAdult(?int $nbAdult): self
    {
        $this->nbAdult = $nbAdult;

        return $this;
    }

    public function getNbChild(): ?int
    {
        return $this->nbChild;
    }
    public function getnb_child(): ?int
    {
        return $this->nbChild;
    }

    public function setNbChild(?int $nbChild): self
    {
        $this->nbChild = $nbChild;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesCompo(): Collection
    {
        return $this->annoncesCompo;
    }

    public function addAnnoncesCompo(Annonce $annoncesCompo): self
    {
        if (!$this->annoncesCompo->contains($annoncesCompo)) {
            $this->annoncesCompo->add($annoncesCompo);
            $annoncesCompo->setComposition($this);
        }

        return $this;
    }

    public function removeAnnoncesCompo(Annonce $annoncesCompo): self
    {
        if ($this->annoncesCompo->removeElement($annoncesCompo)) {
            // set the owning side to null (unless already changed)
            if ($annoncesCompo->getComposition() === $this) {
                $annoncesCompo->setComposition(null);
            }
        }

        return $this;
    }
}
