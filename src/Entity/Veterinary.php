<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use CoralMedia\Bundle\PetClinicBundle\Repository\VeterinaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VeterinaryRepository::class)
 * @ORM\Table(name="`pc_veterinaries`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"veterinary:read", "specialty:read"}},
 *     denormalizationContext={"groups"={"veterinary:write"}},
 * )
 */
class Veterinary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"veterinary:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"veterinary:read", "veterinary:write"})
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"veterinary:read", "veterinary:write"})
     */
    private string $lastName;

    /**
     * @ORM\ManyToMany(targetEntity=Specialty::class, inversedBy="veterinaries")
     * @ORM\JoinTable(name="`pc_veterinaries_specialties`")
     * @Groups({"veterinary:read", "veterinary:write", "specialty:read"})
     */
    private ?Collection $specialties;

    public function __construct()
    {
        $this->specialties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Specialty[]
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(Specialty $specialty): self
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties[] = $specialty;
        }

        return $this;
    }

    public function removeSpecialty(Specialty $specialty): self
    {
        $this->specialties->removeElement($specialty);

        return $this;
    }
}
