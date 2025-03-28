<?php

namespace App\Repositories\Eloquent;

use App\Models\MembershipRequest;
use App\Repositories\Interfaces\MembershipRequestInterface;
use Illuminate\Database\Eloquent\Collection;

class MembershipRequestRepository implements MembershipRequestInterface
{
    protected $model;

    public function __construct(MembershipRequest $model)
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

    public function findByBankId($bankId)
    {
        return MembershipRequest::where('bank_id', $bankId)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $request = $this->find($id);
        $request->update($data);
        return $request;
    }

    public function delete(int $id)
    {
        $request = $this->find($id);
        $request->delete();
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->firstOrFail();
    }
}
