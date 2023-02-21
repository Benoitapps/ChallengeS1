<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Annonce::class)]
    private Collection $annoncesUser;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Annonce::class)]
    private Collection $annoncesCreator;

    #[ORM\OneToMany(mappedBy: 'payeur', targetEntity: Payment::class)]
    private Collection $payments;

    #[ORM\ManyToMany(targetEntity: Annonce::class, mappedBy: 'buyer')]
    private Collection $annoncesBuyer;

    #[ORM\OneToMany(mappedBy: 'acheteur', targetEntity: Place::class)]
    private Collection $placesUser;


    public function __construct()
    {
        $this->annoncesUser = new ArrayCollection();
        $this->annoncesCreator = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->annoncesBuyer = new ArrayCollection();
        $this->placesUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesUser(): Collection
    {
        return $this->annoncesUser;
    }

    public function addAnnoncesUser(Annonce $annoncesUser): self
    {
        if (!$this->annoncesUser->contains($annoncesUser)) {
            $this->annoncesUser->add($annoncesUser);
            $annoncesUser->setClient($this);
        }

        return $this;
    }

    public function removeAnnoncesUser(Annonce $annoncesUser): self
    {
        if ($this->annoncesUser->removeElement($annoncesUser)) {
            // set the owning side to null (unless already changed)
            if ($annoncesUser->getClient() === $this) {
                $annoncesUser->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesCreator(): Collection
    {
        return $this->annoncesCreator;
    }

    public function addAnnoncesCreator(Annonce $annoncesCreator): self
    {
        if (!$this->annoncesCreator->contains($annoncesCreator)) {
            $this->annoncesCreator->add($annoncesCreator);
            $annoncesCreator->setCreator($this);
        }

        return $this;
    }

    public function removeAnnoncesCreator(Annonce $annoncesCreator): self
    {
        if ($this->annoncesCreator->removeElement($annoncesCreator)) {
            // set the owning side to null (unless already changed)
            if ($annoncesCreator->getCreator() === $this) {
                $annoncesCreator->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setPayeur($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getPayeur() === $this) {
                $payment->setPayeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoncesBuyer(): Collection
    {
        return $this->annoncesBuyer;
    }

    public function addAnnoncesBuyer(Annonce $annoncesBuyer): self
    {
        if (!$this->annoncesBuyer->contains($annoncesBuyer)) {
            $this->annoncesBuyer->add($annoncesBuyer);
            $annoncesBuyer->addBuyer($this);
        }

        return $this;
    }

    public function removeAnnoncesBuyer(Annonce $annoncesBuyer): self
    {
        if ($this->annoncesBuyer->removeElement($annoncesBuyer)) {
            $annoncesBuyer->removeBuyer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlacesUser(): Collection
    {
        return $this->placesUser;
    }

    public function addPlacesUser(Place $placesUser): self
    {
        if (!$this->placesUser->contains($placesUser)) {
            $this->placesUser->add($placesUser);
            $placesUser->setAcheteur($this);
        }

        return $this;
    }

    public function removePlacesUser(Place $placesUser): self
    {
        if ($this->placesUser->removeElement($placesUser)) {
            // set the owning side to null (unless already changed)
            if ($placesUser->getAcheteur() === $this) {
                $placesUser->setAcheteur(null);
            }
        }

        return $this;
    }

}