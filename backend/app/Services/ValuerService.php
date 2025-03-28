<?php

namespace App\Services;

use App\Repositories\Interfaces\ValuerInterface;

class ValuerService
{
    protected $valuerRepository;

    public function __construct(ValuerInterface $valuerRepository)
    {
        $this->valuerRepository = $valuerRepository;
    }

    public function getAllValuers()
    {
        return $this->valuerRepository->all();
    }

    public function getValuerById(int $id)
    {
        return $this->valuerRepository->find($id);
    }

    public function createValuer(array $data)
    {
        return $this->valuerRepository->create($data);
    }

    public function updateValuer(int $id, array $data)
    {
        return $this->valuerRepository->update($id, $data);
    }

    public function deleteValuer(int $id)
    {
        $this->valuerRepository->delete($id);
    }

    public function getValuerByUserId(int $userId)
    {
        return $this->valuerRepository->findByUserId($userId);
    }
}
