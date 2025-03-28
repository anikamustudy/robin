<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BankTypeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankTypeController extends Controller
{

    protected $bankTypeRepository;

    public function __construct(BankTypeInterface $bankTypeRepository)
    {
        $this->bankTypeRepository = $bankTypeRepository;
    }

    public function index()
    {
        $bankTypes = $this->bankTypeRepository->all()->load('creator');
        return response()->json($bankTypes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bank_types,name',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $bankType = $this->bankTypeRepository->create($data);
        $bankType->load('creator');
        return response()->json($bankType, 201);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bank_types,name,' . $id,
        ]);

        $bankType = $this->bankTypeRepository->update($id, $request->all());
        $bankType->load('creator');
        return response()->json($bankType);
    }

    public function destroy($id)
    {
        $this->bankTypeRepository->delete($id);
        return response()->json(['message' => 'Bank type deleted']);
    }
}
