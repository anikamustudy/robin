<?php

namespace App\Repositories\Eloquent;

use App\Models\Bank;
use App\Repositories\Interfaces\BankInterface;
use Illuminate\Database\Eloquent\Collection;

class BankRepository implements BankInterface
{
    protected $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $bank = $this->find($id);
        $bank->update($data);
        return $bank;
    }

    public function delete(int $id)
    {
        $bank = $this->find($id);
        $bank->delete();
    }

    public function findByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->firstOrFail();
    }
}
