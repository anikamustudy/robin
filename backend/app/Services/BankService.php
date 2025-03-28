<?php

namespace App\Services;

use App\Repositories\Interfaces\BankInterface;

class BankService
{
    protected $bankRepository;

    public function __construct(BankInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function getAllBanks()
    {
        return $this->bankRepository->all();
    }

    public function getBankById(int $id)
    {
        return $this->bankRepository->find($id);
    }

    public function createBank(array $data)
    {
        return $this->bankRepository->create($data);
    }

    public function updateBank(int $id, array $data)
    {
        return $this->bankRepository->update($id, $data);
    }

    public function deleteBank(int $id)
    {
        $this->bankRepository->delete($id);
    }

    public function getBankByUserId(int $userId)
    {
        return $this->bankRepository->findByUserId($userId);
    }
}
