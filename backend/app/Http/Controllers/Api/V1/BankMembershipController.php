<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MembershipRequestResource;
use App\Models\Bank;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankMembershipController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }


    public function profile(Request $request)
{
    $bank = $this->membershipService->getBankIdForUser($request->Auth::user()->id);
    return response()->json(Bank::findOrFail($bank));
}

    public function index()
    {
        $bankId = $this->membershipService->getBankIdForUser(Auth::user()->id);
        $membershipRequests = $this->membershipService->getRequestsForBank($bankId);
        return MembershipRequestResource::collection($membershipRequests);
    }

    public function stats()
    {
        $bankId = $this->membershipService->getBankIdForUser(Auth::user()->id);
        $requests = $this->membershipService->getRequestsForBank($bankId);
        $stats = [
            'pending' => $requests->where('status', 'pending')->count(),
            'approved' => $requests->where('status', 'approved')->count(),
            'rejected' => $requests->where('status', 'rejected')->count(),
            'blacklisted' => $requests->where('status', 'blacklisted')->count(),
        ];

        return response()->json($stats);
    }

    public function requestsByStatus($status)
    {
        $validStatuses = ['pending', 'approved', 'rejected', 'blacklisted'];
        if (!in_array($status, $validStatuses)) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $bankId = $this->membershipService->getBankIdForUser(Auth::user()->id);
        $requests = $this->membershipService->getRequestsForBank($bankId)->where('status', $status);
        return MembershipRequestResource::collection($requests);
    }
}
