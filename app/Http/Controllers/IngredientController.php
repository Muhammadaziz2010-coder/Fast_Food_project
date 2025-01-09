<?php
namespace App\Http\Controllers;


use App\Http\Requests\IngredientRequest;
use App\Models\Ingredient;
use App\Services\IngredientService;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IngredientController extends ApiController
{
public function __construct(readonly protected IngredientService $service) {}

public function index(): JsonResponse
{
return $this->successResponse($this->service->all());
}

public function show(Ingredient $ingredient): JsonResponse
{
return $this->successResponse($this->service->show($ingredient));
}

/**
* @throws ValidatorException
*/
public function store(IngredientRequest $request): JsonResponse
{
$validated = $request->validated();

if (!empty($validated['expiration_date'])) {
$validated['expiration_date'] = Carbon::createFromFormat('d.m.Y', $validated['expiration_date'])->format('Y-m-d');
}

return $this->successResponse($this->service->create($validated), Response::HTTP_CREATED);
}

/**
* @throws ValidatorException
*/
public function update(IngredientRequest $request, Ingredient $ingredient): JsonResponse
{
$validated = $request->validated();

if (!empty($validated['expiration_date'])) {
$validated['expiration_date'] = Carbon::createFromFormat('d.m.Y', $validated['expiration_date'])->format('Y-m-d');
}

return $this->successResponse($this->service->update($ingredient, $validated));
}

public function destroy(Ingredient $ingredient): JsonResponse
{
if ($this->service->delete($ingredient)) {
return $this->successResponse([
    "ok" => true,
    "message" => "Ingredient deleted successfully"
], Response::HTTP_NO_CONTENT);
}

return $this->errorResponse('No deleting', Response::HTTP_INTERNAL_SERVER_ERROR);
}
}
