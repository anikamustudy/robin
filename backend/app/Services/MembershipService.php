<?php

namespace App\Services;

use App\Repositories\Interfaces\BankInterface;
use App\Repositories\Interfaces\MembershipNotificationInterface;
use App\Repositories\Interfaces\MembershipRequestInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\ValuerInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MembershipService
{
    protected $membershipRequestRepository;
    protected $userRepository;
    protected $bankRepository;
    protected $valuerRepository;
    protected $notificationRepository;

    public function __construct(
        MembershipRequestInterface $membershipRequestRepository,
        UserInterface $userRepository,
        BankInterface $bankRepository,
        ValuerInterface $valuerRepository,
        MembershipNotificationInterface $notificationRepository
    ) {
        $this->membershipRequestRepository = $membershipRequestRepository;
        $this->userRepository = $userRepository;
        $this->bankRepository = $bankRepository;
        $this->valuerRepository = $valuerRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getAllRequests()
    {
        return $this->membershipRequestRepository->all();
    }
    public function getBankIdForUser(int $userId)
    {
        $bank = $this->bankRepository->findByUserId($userId);
        if (!$bank) {
            throw new \Exception('No bank associated with this user.');
        }
        return $bank->id;
    }

    public function getValuerIdForUser(int $userId)
    {
        $valuer = $this->valuerRepository->findByUserId($userId);
        return $valuer->id;
    }


    public function getRequestsForBank(int $bankId)
    {
        return $this->membershipRequestRepository->findByBankId($bankId);
        //return $this->membershipRequestRepository->all()->where('bank_id', $bankId);
        //return $this->membershipRequestRepository->all()->where('role', 'bank_staff')->where('bank_id', $bankId);
    }

    public function getRequestsForValuer(int $valuerId)
    {
        return $this->membershipRequestRepository->all()->where('role', 'valuer_staff')->where('valuer_id', $valuerId);
    }



    public function createRequest(array $data)
    {
        return $this->membershipRequestRepository->create($data);
    }

    public function approveRequest(int $requestId, int $reviewerId, ?string $bankName = null, ?string $bankBranch = null, ?string $valuerOrg = null)
    {
        $request = $this->membershipRequestRepository->find($requestId);
        if ($request->status !== 'pending') {
            throw new \Exception('Request already processed.');
        }

        $reviewer = $this->userRepository->find($reviewerId);
        $this->authorizeReviewer($reviewer, $request, $bankName, $bankBranch, $valuerOrg);

        $tempPassword = Str::random(10);
        $userData = [
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'name' => $request->name,
            'role' => $request->role,
            'status' => 'approved',
        ];
        $user = $this->userRepository->create($userData);

        if ($request->role === 'bank') {
            $this->bankRepository->create([
                'user_id' => $user->id,
                'bank_type_id' => 1,
                'name' => $request->name,
                'address' => 'N/A',
            ]);
        } elseif ($request->role === 'valuer') {
            $this->valuerRepository->create([
                'user_id' => $user->id,
                'org_name' => $request->name,
                'designation' => 'Engineer',
            ]);
        } elseif ($request->role === 'bank_staff') {
            $bankStaffData = [
                'bank_id' => $request->bank_id,
                'branch_id' => $request->branch_id,
                'user_id' => $user->id,
                'designation' => 'Staff',
            ];
            \App\Models\BankStaff::create($bankStaffData);
        } elseif ($request->role === 'valuer_staff') {
            $valuerStaffData = [
                'valuer_id' => $request->valuer_id,
                'user_id' => $user->id,
                'designation' => 'Staff',
            ];
            \App\Models\ValuerStaff::create($valuerStaffData);
        }

        $this->membershipRequestRepository->update($requestId, [
            'status' => 'approved',
            'temp_password' => $tempPassword,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);

        $this->notificationRepository->create([
            'membership_request_id' => $requestId,
            'user_id' => $user->id,
            'type' => 'approval',
            'message' => "Your request is approved. Use temporary password: $tempPassword at /reset-password",
        ]);

        return $user;
    }

    public function rejectRequest(int $requestId, int $reviewerId, string $reason, string $status = 'rejected', ?string $bankName = null, ?string $bankBranch = null, ?string $valuerOrg = null)
    {
        $request = $this->membershipRequestRepository->find($requestId);
        if ($request->status !== 'pending') {
            throw new \Exception('Request already processed.');
        }

        $reviewer = $this->userRepository->find($reviewerId);
        $this->authorizeReviewer($reviewer, $request, $bankName, $bankBranch, $valuerOrg);

        $this->membershipRequestRepository->update($requestId, [
            'status' => $status,
            'reason' => $reason,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);

        $this->notificationRepository->create([
            'membership_request_id' => $requestId,
            'type' => $status,
            'message' => "Your request was $status. Reason: $reason",
        ]);
    }

    protected function authorizeReviewer($reviewer, $request, ?string $bankName = null, ?string $bankBranch = null, ?string $valuerOrg = null)
    {
        if ($reviewer->role === 'admin') {
            return; // Admin can approve/reject anything
        }

        if ($reviewer->role === 'bank' && $request->role === 'bank_staff') {
            $bank = $this->bankRepository->findByUserId($reviewer->id);
            if ($bank->id !== $request->bank_id) {
                throw new \Exception('Unauthorized: You can only approve staff for your bank.');
            }
            if ($bankName && $bank->name !== $bankName) {
                throw new \Exception('Unauthorized: Bank name mismatch.');
            }
            if ($bankBranch) {
                $branch = \App\Models\Branch::where('bank_id', $bank->id)->where('name', $bankBranch)->first();
                if (!$branch || $branch->id !== $request->branch_id) {
                    throw new \Exception('Unauthorized: Branch mismatch.');
                }
            }
            return;
        }

        if ($reviewer->role === 'valuer' && $request->role === 'valuer_staff') {
            $valuer = $this->valuerRepository->findByUserId($reviewer->id);
            if ($valuer->id !== $request->valuer_id) {
                throw new \Exception('Unauthorized: You can only approve staff for your organization.');
            }
            if ($valuerOrg && $valuer->org_name !== $valuerOrg) {
                throw new \Exception('Unauthorized: Organization mismatch.');
            }
            return;
        }

        throw new \Exception('Unauthorized: Insufficient permissions.');
    }
}
