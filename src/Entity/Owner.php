<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use CoralMedia\Bundle\PetClinicBundle\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 * @ORM\Table(name="`pc_owners`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"owner:read", "pet:read"}},
 *     denormalizationContext={"groups"={"owner:write"}},
 * )
 */
class Owner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"owner:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"owner:read", "owner:write"})
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"owner:read", "owner:write"})
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"owner:read", "owner:write"})
     */
    private string $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Pet::class, mappedBy="owner")
     * @Groups({"owner:read", "pet:read"})
     * @ApiSubresource()
     */
    private Collection $pets;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Owner
     */
    public function setFirstName(string $firstName): Owner
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Owner
     */
    public function setLastName(string $lastName): Owner
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return Owner
     */
    public function setTelephone(string $telephone): Owner
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return Collection|Pet[]
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
            $pet->setOwner($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getOwner() === $this) {
                $pet->setOwner(null);
            }
        }

        return $this;
    }
}
