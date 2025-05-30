<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\ORM\EntityManagerInterface;

class EmpresaRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Empresa::class);
    }

    public function create(string $nome): Empresa
    {
        $empresa = new Empresa();
        $empresa->setNome($nome);

        $this->em->persist($empresa);
        $this->em->flush();

        return $empresa;
    }

    public function update(Empresa $empresa, string $nome): Empresa
    {
        $empresa->setNome($nome);
        $this->em->flush();

        return $empresa;
    }

    public function delete(Empresa $empresa): void
    {
        $this->em->remove($empresa);
        $this->em->flush();
    }
}
