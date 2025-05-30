<?php

namespace App\Repository;

use App\Entity\Empresa;
use App\Entity\Socio;
use Doctrine\ORM\EntityManagerInterface;

class SocioRepository extends BaseRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Socio::class);
    }

    public function create(string $nome, Empresa $empresa): Socio
    {
        $socio = new Socio();
        $socio->setNome($nome);

        $socio->setEmpresa($empresa);

        $this->em->persist($socio);
        $this->em->flush();

        return $socio;
    }

    public function update(Socio $socio, string $nome): Socio
    {
        $socio->setNome($nome);
        $this->em->flush();

        return $socio;
    }

    public function delete(Socio $socio): void
    {
        $this->em->remove($socio);
        $this->em->flush();
    }
}
