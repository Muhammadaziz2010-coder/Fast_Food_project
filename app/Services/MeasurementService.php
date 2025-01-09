<?php

namespace App\Services;


use App\Models\Measurement;
use App\Repositories\Measurement\MeasurementRepository;
use App\Transformers\MeasurementTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class MeasurementService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, MeasurementRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'measurement');
    }


    public function show(Measurement $measurement): array
    {
        $fractal = new Manager();
        $resource = new Item($measurement, new MeasurementTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'measurement');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {
        $measurement =  $this->repository->skipPresenter()->create($data);


       return $this->show($measurement);
    }


    public function update(Measurement $measurement, $data): array
    {

        $measurement->update($data);



        return $this->show($measurement);
    }

    public function delete(Measurement $measurement): ?bool
    {
        return $measurement->delete();
    }

    public function forceDelete(Measurement $measurement): ?bool
    {
        return $measurement->forceDelete();
    }
}
