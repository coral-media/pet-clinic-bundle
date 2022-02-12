<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use CoralMedia\Bundle\PetClinicBundle\Repository\PetTypeRepository;

/**
 * @ORM\Entity(repositoryClass=PetTypeRepository::class)
 * @ORM\Table(name="`pc_pet_types`")
 * @ApiResource(
 *     routePrefix="/pet-clinic"
 * )
 */
class PetType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Pet::class, mappedBy="petType")
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PetType
     */
    public function setName(string $name): PetType
    {
        $this->name = $name;
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
            $pet->setPetType($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getPetType() === $this) {
                $pet->setPetType(null);
            }
        }

        return $this;
    }
}
