<?php

namespace App\Repositories\Eloquent;

use App\Models\BankType;
use App\Repositories\Interfaces\BankTypeInterface;
use Illuminate\Database\Eloquent\Collection;

class BankTypeRepository implements BankTypeInterface{

    public function all(): Collection
    {
        return BankType::all();
    }

    public function find(int $id){
        return BankType::findOrFail($id);
    }

    public function create(array $data)
    {
        return BankType::create($data);
    }

    public function update(int $id, array $data)
    {
        $bankType = BankType::findOrFail($id);
        $bankType->update($data);
        return $bankType;
    }

    public function delete(int $id)
    {
        $bankType = BankType::findOrFail($id);
        $bankType->delete();
    }

}
