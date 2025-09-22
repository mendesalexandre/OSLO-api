<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    /**
     * Success response helper.
     */
    protected function successResponse($data = null, array $extra = [], int $status = 200): JsonResponse
    {
        $response = array_merge([
            'success' => true,
            'data' => $data
        ], $extra);

        return response()->json($response, $status);
    }

    /**
     * Error response helper.
     */
    protected function errorResponse(string $message, array $errors = [], int $status = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * Validation error response.
     */
    protected function validationErrorResponse(array $errors, string $message = 'Dados inválidos.'): JsonResponse
    {
        return $this->errorResponse($message, $errors, 422);
    }

    /**
     * Not found response.
     */
    protected function notFoundResponse(string $message = 'Recurso não encontrado.'): JsonResponse
    {
        return $this->errorResponse($message, [], 404);
    }

    /**
     * Forbidden response.
     */
    protected function forbiddenResponse(string $message = 'Você não tem permissão para esta ação.'): JsonResponse
    {
        return $this->errorResponse($message, [], 403);
    }

    /**
     * Unauthorized response.
     */
    protected function unauthorizedResponse(string $message = 'Não autorizado.'): JsonResponse
    {
        return $this->errorResponse($message, [], 401);
    }

    /**
     * Created response.
     */
    protected function createdResponse($data = null, string $message = 'Criado com sucesso.'): JsonResponse
    {
        return $this->successResponse($data, ['message' => $message], 201);
    }

    /**
     * Updated response.
     */
    protected function updatedResponse($data = null, string $message = 'Atualizado com sucesso.'): JsonResponse
    {
        return $this->successResponse($data, ['message' => $message]);
    }

    /**
     * Deleted response.
     */
    protected function deletedResponse(string $message = 'Excluído com sucesso.'): JsonResponse
    {
        return $this->successResponse(null, ['message' => $message]);
    }

    /**
     * No content response.
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Format pagination data.
     */
    protected function formatPagination(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];
    }

    /**
     * Success response with pagination.
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator, array $extra = []): JsonResponse
    {
        return $this->successResponse($paginator->items(), array_merge([
            'pagination' => $this->formatPagination($paginator)
        ], $extra));
    }

    /**
     * Collection response.
     */
    protected function collectionResponse($collection, string $message = null): JsonResponse
    {
        $extra = [];
        if ($message) {
            $extra['message'] = $message;
        }

        $extra['count'] = is_countable($collection) ? count($collection) : 0;

        return $this->successResponse($collection, $extra);
    }
}
