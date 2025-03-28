<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipReviewRequest;
use App\Http\Requests\MembershipStoreRequest;
use App\Http\Resources\V1\MembershipRequestResource;
use App\Http\Resources\V1\UserResource;
use App\Models\MembershipRequest;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function index(Request $request)
    {
        $membershipRequests = $this->membershipService->getAllRequests();
        return MembershipRequestResource::collection($membershipRequests);
    }


    public function createRequest(Request $request)
    {
        $request->validate([
            'role' => 'required|in:bank,valuer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:membership_requests,email',
        ]);

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'status' => 'pending',
        ];

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'status' => 'pending',
            'bank_id' => $request->role === 'bank' ? null : null,
            'valuer_id' => $request->role === 'valuer' ? null : null,
        ];
        $membershipRequest = $this->membershipService->createRequest($data);

        return response()->json(['message' => 'Membership request submitted successfully!', 'request' => $membershipRequest], 201);
    }


    public function store(MembershipStoreRequest $request)
    {
        $membershipRequest = $this->membershipService->createRequest($request->validated());
        return new MembershipRequestResource($membershipRequest);
    }


    public function approve(MembershipReviewRequest $request, $id, $bankName = null, $bankBranch = null, $valuerOrg = null)
    {
        $membershipRequest = MembershipRequest::findOrFail($id);
        $user = $this->membershipService->approveRequest($id, Auth::user()->id, $bankName, $bankBranch, $valuerOrg);
        return new UserResource($user);
    }

    public function reject(Request $request, $id, $bankName = null, $bankBranch = null, $valuerOrg = null)
    {
        $membershipRequest = MembershipRequest::findOrFail($id);
        $this->membershipService->rejectRequest($id, Auth::user()->id, $request->validated()['reason'], $request->validated()['status'] ?? 'rejected', $bankName, $bankBranch, $valuerOrg);
        return response()->json(['message' => 'Request processed'], 200);
    }
}
