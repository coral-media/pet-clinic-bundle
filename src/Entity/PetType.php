<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use CoralMedia\Bundle\PetClinicBundle\Repository\PetTypeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PetTypeRepository::class)
 * @ORM\Table(name="`pc_pet_types`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"pet_type:read", "pet:read"}},
 *     denormalizationContext={"groups"={"pet_type:write"}},
 * )
 */
class PetType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"pet_type:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Groups({"pet_type:read", "pet_type:write"})
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Pet::class, mappedBy="petType")
     * @Groups({"pet_type:read", "pet:read"})
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
