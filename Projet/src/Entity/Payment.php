<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumCarte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $expiration = null;

    #[ORM\Column]
    private ?int $cvv = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    private ?User $payeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCarte(): ?int
    {
        return $this->NumCarte;
    }

    public function setNumCarte(int $NumCarte): self
    {
        $this->NumCarte = $NumCarte;

        return $this;
    }

    public function getExpiration(): ?\DateTimeInterface
    {
        return $this->expiration;
    }

    public function setExpiration(\DateTimeInterface $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function getCvv(): ?int
    {
        return $this->cvv;
    }

    public function setCvv(int $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getPayeur(): ?User
    {
        return $this->payeur;
    }

    public function setPayeur(?User $payeur): self
    {
        $this->payeur = $payeur;

        return $this;
    }
}
