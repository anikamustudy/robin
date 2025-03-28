<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MembershipRequestResource;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValuerMembershipController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function index()
    {
        $valuerId = $this->membershipService->getValuerIdForUser(Auth::user()->id);
        $membershipRequests = $this->membershipService->getRequestsForValuer($valuerId);
        return MembershipRequestResource::collection($membershipRequests);
    }
}
