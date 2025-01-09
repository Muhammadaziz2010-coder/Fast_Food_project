<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementRequest;
use App\Models\Measurement;
use App\Services\MeasurementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MeasurementController extends ApiController
{
    protected MeasurementService $service;

    public function __construct(MeasurementService $measurementService)
    {
        $this->service = $measurementService;
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }

    public function show(Measurement $measurement): JsonResponse
    {
        return $this->successResponse($this->service->show($measurement));
    }

    public function store(MeasurementRequest $request): JsonResponse
    {
        try {
            // If validation passes, proceed with creating the resource
            $validatedData = $request->validated();
            return $this->successResponse($this->service->create($validatedData), ResponseAlias::HTTP_CREATED);
        } catch (ValidationException $exception) {
            return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $exception->errors());
        }
    }
    public function update(Measurement $measurement, MeasurementRequest $request): JsonResponse
    {
        if($request->validated()){

            return $this->successResponse($this->service->update($measurement,$request->validated()), ResponseAlias::HTTP_CREATED);
        }

        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    public function destroy(Measurement $measurement): JsonResponse
    {
        $this->service->delete($measurement);

        return $this->successResponse([
            "message" => "Measurement deleted"
        ]);
    }

    public function forceDelete(Measurement $measurement): JsonResponse
    {
        $this->service->forceDelete($measurement);

        return $this->successResponse([
            "message" => "Measurement has been permanently deleted"
        ]);
    }
}
