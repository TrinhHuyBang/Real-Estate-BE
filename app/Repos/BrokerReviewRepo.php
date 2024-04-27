<?php
namespace App\Repos;

use App\Interfaces\BrokerReviewRepoInterface;
use App\Models\BrokerReview;

class BrokerReviewRepo implements BrokerReviewRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        $notification = new BrokerReview();
        $notification->fill($data)->save();
        return $notification;
    }
    public function edit($id, $data)
    {
        $notification = BrokerReview::where('id', $id)->first();
        $notification->fill($data)->save();
        return $notification;
    }
    public function delete($id)
    {
        return BrokerReview::where('id', $id)->delete();
    }

}