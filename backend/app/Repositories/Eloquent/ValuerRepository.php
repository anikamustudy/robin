<?php

namespace App\Repositories\Eloquent;

use App\Models\Valuer;
use App\Repositories\Interfaces\ValuerInterface;
use Illuminate\Database\Eloquent\Collection;

class ValuerRepository implements ValuerInterface
{
    protected $model;

    public function __construct(Valuer $model)
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
        $valuer = $this->find($id);
        $valuer->update($data);
        return $valuer;
    }

    public function delete(int $id)
    {
        $valuer = $this->find($id);
        $valuer->delete();
    }

    public function findByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->firstOrFail();
    }
}
