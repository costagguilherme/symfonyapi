<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseRepository
{
    protected EntityManagerInterface $em;
    protected $repo;

    public function __construct(EntityManagerInterface $em, string $entityClass)
    {
        $this->em = $em;
        $this->repo = $em->getRepository($entityClass);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }

    public function find(int $id): ?object
    {
        return $this->repo->find($id);
    }
}
