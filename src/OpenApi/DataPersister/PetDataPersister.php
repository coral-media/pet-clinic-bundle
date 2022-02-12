<?php

namespace CoralMedia\Bundle\PetClinicBundle\OpenApi\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\ResumableDataPersisterInterface;
use CoralMedia\Bundle\PetClinicBundle\Entity\Pet;

class PetDataPersister implements ContextAwareDataPersisterInterface, ResumableDataPersisterInterface
{
    protected ContextAwareDataPersisterInterface $decorated;

    public function __construct(
        ContextAwareDataPersisterInterface $decorated
    ) {
        $this->decorated = $decorated;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Pet) {
            $data->setName(strtoupper($data->getName()));
        }
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }

    public function resumable(array $context = []): bool
    {
        return true;
    }
}
