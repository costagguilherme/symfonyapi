<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Entity\Empresa;
use App\Repository\SocioRepository;
use App\Repository\EmpresaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/socios')]
class SocioController extends AbstractController
{
    private SocioRepository $socioRepository;
    private EmpresaRepository $empresaRepository;

    public function __construct(SocioRepository $socioRepository, EmpresaRepository $empresaRepository)
    {
        $this->socioRepository = $socioRepository;
        $this->empresaRepository = $empresaRepository;
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $socios = $this->socioRepository->findAll();
        return $this->json($socios);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['nome']) || empty($data['empresa_id'])) {
            return $this->json(['erro' => 'Nome e empresa_id são obrigatórios'], 400);
        }

        $empresa = $this->empresaRepository->find($data['empresa_id']);
        if (!$empresa) {
            return $this->json(['erro' => 'Empresa não encontrada'], 404);
        }

        $socio = $this->socioRepository->create($data['nome'], $empresa);
        return $this->json($socio, 201);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        $socio = $this->socioRepository->find($id);
        if (!$socio) {
            return $this->json(['erro' => 'Sócio não encontrado'], 404);
        }

        return $this->json($socio);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['nome'])) {
            return $this->json(['erro' => 'Nome é obrigatório'], 400);
        }

        $socio = $this->socioRepository->find($id);
        if (!$socio) {
            return $this->json(['erro' => 'Sócio não encontrado'], 404);
        }

        $socio = $this->socioRepository->update($socio, $data['nome']);
        return $this->json($socio, 200);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $socio = $this->socioRepository->find($id);
        if (!$socio) {
            return $this->json(['erro' => 'Sócio não encontrado'], 404);
        }

        $this->socioRepository->delete($socio);
        return $this->json(['message' => 'Sócio deletado com sucesso!'], 200);
    }
}
