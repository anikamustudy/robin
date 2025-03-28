<?php

namespace App\Repositories\Eloquent;

use App\Models\MembershipNotification;
use App\Repositories\Interfaces\MembershipNotificationInterface;
use Illuminate\Database\Eloquent\Collection;

class MembershipNotificationRepository implements MembershipNotificationInterface
{
    protected $model;

    public function __construct(MembershipNotification $model)
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
        $notification = $this->find($id);
        $notification->update($data);
        return $notification;
    }

    public function delete(int $id)
    {
        $notification = $this->find($id);
        $notification->delete();
    }
}
