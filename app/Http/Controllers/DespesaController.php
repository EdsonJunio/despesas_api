<?php

namespace App\Http\Controllers;

use App\Http\Requests\DespesaRequest;
use App\Http\Resources\DespesaResource;
use App\Models\Despesa;
use App\Services\DespesaService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class DespesaController extends Controller
{
    private $despesaService;

    public function __construct(DespesaService $despesaService)
    {
        $this->despesaService = $despesaService;
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $despesas = $this->despesaService->getAll();
            return DespesaResource::collection($despesas)
                ->additional(['message' => 'Despesas recuperadas com sucesso']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao recuperar as despesas', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function store(DespesaRequest $request): JsonResponse
    {
        $this->authorize('create', Despesa::class);

        try {
            $validatedData = $request->validated();
            $validatedData['usuario_id'] = auth()->id();

            $createdDespesa = $this->despesaService->create($validatedData);

            return (new DespesaResource($createdDespesa))
                ->additional(['message' => 'Despesa criada com sucesso'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao criar a despesa', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Despesa $despesa): JsonResponse|DespesaResource
    {
        $this->authorize('view', $despesa);

        try {
            return (new DespesaResource($despesa))
                ->additional(['message' => 'Despesa recuperada com sucesso']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao recuperar a despesa', 'error' => $e->getMessage()], 500);
        }

    }

    /**
     * @throws AuthorizationException
     */
    public function update(DespesaRequest $request, Despesa $despesa): JsonResponse|DespesaResource
    {
        $this->authorize('update', $despesa);

        try {
            $updatedDespesa = $this->despesaService->update($despesa, $request->validated());
            return (new DespesaResource($updatedDespesa))
                ->additional(['message' => 'Despesa atualizada com sucesso']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao atualizar a despesa', 'error' => $e->getMessage()], 500);
        }

    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Despesa $despesa): JsonResponse
    {
        $this->authorize('delete', $despesa);

        try {
            $this->despesaService->delete($despesa);
            return response()->json(['message' => 'Despesa deletada com sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao deletar a despesa', 'error' => $e->getMessage()], 500);
        }
    }
}
