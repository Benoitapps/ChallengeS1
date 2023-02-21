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


    public function __construct()
    {

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



}
