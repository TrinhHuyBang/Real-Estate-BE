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

    }
    public function delete($id)
    {
        
    }

}