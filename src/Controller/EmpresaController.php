<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/empresas')]
class EmpresaController extends AbstractController
{
    private EmpresaRepository $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $empresas = $this->empresaRepository->findAll();
        return $this->json($empresas);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nome']) || empty($data['nome'])) {
            return $this->json(['erro' => 'Nome é obrigatório'], 400);
        }

        $empresa = $this->empresaRepository->create($data['nome']);
        return $this->json($empresa, 201);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        $empresa = $this->empresaRepository->find($id);

        if (!$empresa) {
            return $this->json(['erro' => 'Empresa não encontrada'], 404);
        }

        return $this->json($empresa);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nome']) || empty($data['nome'])) {
            return $this->json(['erro' => 'Nome é obrigatório'], 400);
        }

        $empresa = $this->empresaRepository->find($id);

        if (!$empresa) {
            return $this->json(['erro' => 'Empresa não encontrada'], 404);
        }

        $empresa = $this->empresaRepository->update($empresa, $data['nome']);
        return $this->json($empresa);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $empresa = $this->empresaRepository->find($id);

        if (!$empresa) {
            return $this->json(['erro' => 'Empresa não encontrada'], 404);
        }

        $this->empresaRepository->delete($empresa);
        return $this->json(['message' => 'Empresa deletada com sucesso!'], 200);
    }
}
