<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use CoralMedia\Bundle\PetClinicBundle\Repository\PetRepository;

/**
 * @ORM\Entity(repositoryClass=PetRepository::class)
 * @ORM\Table(name="`pc_pets`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"pet:read"}},
 *     denormalizationContext={"groups"={"pet:write"}},
 * )
 */
class Pet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")3
     * @Groups({"pet:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"pet:read", "pet:write"})
     */
    private string $name;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("\DateTimeInterface")
     * @Groups({"pet:read", "pet:write"})
     */
    private DateTime $birthDate;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="pets")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pet:read", "pet:write"})
     */
    private Owner $owner;

    /**
     * @ORM\ManyToOne(targetEntity=PetType::class, inversedBy="pets")
     * @Groups({"pet:read", "pet:write"})
     */
    private ?PetType $petType;

    /**
     * @ORM\OneToMany(targetEntity=Visit::class, mappedBy="pet")
     */
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
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
     * @return Pet
     */
    public function setName(string $name): Pet
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     * @return Pet
     */
    public function setBirthDate(DateTime $birthDate): Pet
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getPetType(): ?PetType
    {
        return $this->petType;
    }

    public function setPetType(?PetType $petType): self
    {
        $this->petType = $petType;

        return $this;
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits[] = $visit;
            $visit->setPet($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->removeElement($visit)) {
            // set the owning side to null (unless already changed)
            if ($visit->getPet() === $this) {
                $visit->setPet(null);
            }
        }

        return $this;
    }
}
