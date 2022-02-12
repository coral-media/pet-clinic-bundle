<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use CoralMedia\Bundle\PetClinicBundle\Repository\SpecialtyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SpecialtyRepository::class)
 * @ORM\Table(name="`pc_specialties`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"specialty:read", "veterinary:read"}},
 *     denormalizationContext={"groups"={"specialty:write"}},
 * )
 */
class Specialty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"specialty:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"specialty:read", "specialty:write"})
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity=Veterinary::class, mappedBy="specialties")
     * @Groups({"specialty:read", "veterinary:read"})
     */
    private Collection $veterinaries;

    public function __construct()
    {
        $this->veterinaries = new ArrayCollection();
    }

    public function getId(): ?int
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
     * @return Specialty
     */
    public function setName(string $name): Specialty
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|Veterinary[]
     */
    public function getVeterinaries(): Collection
    {
        return $this->veterinaries;
    }

    public function addVeterinary(Veterinary $veterinary): self
    {
        if (!$this->veterinaries->contains($veterinary)) {
            $this->veterinaries[] = $veterinary;
            $veterinary->addSpecialty($this);
        }

        return $this;
    }

    public function removeVeterinary(Veterinary $veterinary): self
    {
        if ($this->veterinaries->removeElement($veterinary)) {
            $veterinary->removeSpecialty($this);
        }

        return $this;
    }
}
