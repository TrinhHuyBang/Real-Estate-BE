<?php
namespace App\Repos;

use App\Interfaces\NotificationRepoInterface as InterfacesNotificationRepoInterface;
use App\Models\Notification;

class NotificationRepo implements InterfacesNotificationRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        $notification = new Notification();
        $notification->fill($data)->save();
        return $notification;
    }
    public function edit($id, $data)
    {
        $notification = Notification::where('id', $id)->first();
        $notification->fill($data)->save();
        return $notification;
    }
    public function delete($id)
    {
        return Notification::where('id', $id)->delete();
    }

    public function getCountUnreadByUser($user_id) {
        return Notification::where('user_id', $user_id)->where('status', 0)->count();
    }

    public function list($status = 0) {
        $query = Notification::where('user_id', auth()->user()->id);
        if($status) {
            $query->where('status', 0);
        }
        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);
        return $notifications;
    }
}