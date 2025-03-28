<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MembershipRequestResource;
use App\Services\MembershipService;

class AdminMembershipController extends Controller
{

    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function index()
    {
        $membershipRequests = $this->membershipService->getAllRequests();
        return MembershipRequestResource::collection($membershipRequests);
    }

    public function stats()
    {
        $stats = [
            'pending' => $this->membershipService->getAllRequests()->where('status', 'pending')->count(),
            'approved' => $this->membershipService->getAllRequests()->where('status', 'approved')->count(),
            'rejected' => $this->membershipService->getAllRequests()->where('status', 'rejected')->count(),
            'blacklisted' => $this->membershipService->getAllRequests()->where('status', 'blacklisted')->count(),
        ];

        return response()->json($stats);
    }

    public function requestsByStatus($status)
    {
        $validStatuses = ['pending', 'approved', 'rejected', 'blacklisted'];
        if (!in_array($status, $validStatuses)) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $requests = $this->membershipService->getAllRequests()->where('status', $status);
        return MembershipRequestResource::collection($requests);
    }
}
