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

}