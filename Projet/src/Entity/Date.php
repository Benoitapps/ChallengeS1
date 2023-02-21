<?php

namespace App\Entity;

use App\Repository\DateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateRepository::class)]
class Date
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'dateDepartAller', targetEntity: Annonce::class)]
    private Collection $annoncesDepartAller;

    #[ORM\OneToMany(mappedBy: 'dateDepartArriver', targetEntity: Annonce::class)]
    private Collection $annonceDepartArriver;

    #[ORM\OneToMany(mappedBy: 'dateRetourAller', targetEntity: Annonce::class)]
    private Collection $annoncesDateRetourAller;

    #[ORM\OneToMany(mappedBy: 'dateRetourArriver', targetEntity: Annonce::class)]
    private Collection $annoncesDateRetourArriver;

    public function __construct()
    {
        $this->annoncesDepartAller = new ArrayCollection();
        $this->annonceDepartArriver = new ArrayCollection();
        $this->annoncesDateRetourAller = new ArrayCollection();
        $this->annoncesDateRetourArriver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesDepartAller(): Collection
    {
        return $this->annoncesDepartAller;
    }

    public function addAnnoncesDepartAller(Annonce $annoncesDepartAller): self
    {
        if (!$this->annoncesDepartAller->contains($annoncesDepartAller)) {
            $this->annoncesDepartAller->add($annoncesDepartAller);
            $annoncesDepartAller->setDateDepartAller($this);
        }

        return $this;
    }

    public function removeAnnoncesDepartAller(Annonce $annoncesDepartAller): self
    {
        if ($this->annoncesDepartAller->removeElement($annoncesDepartAller)) {
            // set the owning side to null (unless already changed)
            if ($annoncesDepartAller->getDateDepartAller() === $this) {
                $annoncesDepartAller->setDateDepartAller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonceDepartArriver(): Collection
    {
        return $this->annonceDepartArriver;
    }

    public function addAnnonceDepartArriver(Annonce $annonceDepartArriver): self
    {
        if (!$this->annonceDepartArriver->contains($annonceDepartArriver)) {
            $this->annonceDepartArriver->add($annonceDepartArriver);
            $annonceDepartArriver->setDateDepartArriver($this);
        }

        return $this;
    }

    public function removeAnnonceDepartArriver(Annonce $annonceDepartArriver): self
    {
        if ($this->annonceDepartArriver->removeElement($annonceDepartArriver)) {
            // set the owning side to null (unless already changed)
            if ($annonceDepartArriver->getDateDepartArriver() === $this) {
                $annonceDepartArriver->setDateDepartArriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesDateRetourAller(): Collection
    {
        return $this->annoncesDateRetourAller;
    }

    public function addAnnoncesDateRetourAller(Annonce $annoncesDateRetourAller): self
    {
        if (!$this->annoncesDateRetourAller->contains($annoncesDateRetourAller)) {
            $this->annoncesDateRetourAller->add($annoncesDateRetourAller);
            $annoncesDateRetourAller->setDateRetourAller($this);
        }

        return $this;
    }

    public function removeAnnoncesDateRetourAller(Annonce $annoncesDateRetourAller): self
    {
        if ($this->annoncesDateRetourAller->removeElement($annoncesDateRetourAller)) {
            // set the owning side to null (unless already changed)
            if ($annoncesDateRetourAller->getDateRetourAller() === $this) {
                $annoncesDateRetourAller->setDateRetourAller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesDateRetourArriver(): Collection
    {
        return $this->annoncesDateRetourArriver;
    }

    public function addAnnoncesDateRetourArriver(Annonce $annoncesDateRetourArriver): self
    {
        if (!$this->annoncesDateRetourArriver->contains($annoncesDateRetourArriver)) {
            $this->annoncesDateRetourArriver->add($annoncesDateRetourArriver);
            $annoncesDateRetourArriver->setDateRetourArriver($this);
        }

        return $this;
    }

    public function removeAnnoncesDateRetourArriver(Annonce $annoncesDateRetourArriver): self
    {
        if ($this->annoncesDateRetourArriver->removeElement($annoncesDateRetourArriver)) {
            // set the owning side to null (unless already changed)
            if ($annoncesDateRetourArriver->getDateRetourArriver() === $this) {
                $annoncesDateRetourArriver->setDateRetourArriver(null);
            }
        }

        return $this;
    }
}
