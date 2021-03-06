<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\PetClinicBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\PetClinicBundle\Repository\VisitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VisitRepository::class)
 * @ORM\Table(name="`pc_visits`")
 * @ApiResource(
 *     routePrefix="/pet-clinic",
 *     normalizationContext={"groups"={"visit:read", "pet:read"}},
 *     denormalizationContext={"groups"={"visit:write"}},
 * )
 */
class Visit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"visit:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"visit:read", "visit:write"})
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Pet::class, inversedBy="visits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"visit:read", "visit:write", "pet:read"})
     */
    private Pet $pet;

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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Visit
     */
    public function setDescription(string $description): Visit
    {
        $this->description = $description;
        return $this;
    }

    public function getPet(): Pet
    {
        return $this->pet;
    }

    public function setPet(Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }
}
