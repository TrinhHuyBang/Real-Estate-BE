<?php
namespace App\Repos;

use App\Interfaces\BrokerageAreaRepoInterface;
use App\Models\BrokerageArea;

class BrokerageAreaRepo implements BrokerageAreaRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        $brokerageArea = new BrokerageArea();
        $brokerageArea->fill($data)->save();
        return $brokerageArea;
    }
    public function edit($id, $data)
    {
    }
    public function delete($broker_id)
    {
        return BrokerageArea::where('broker_id', $broker_id)->delete();
    }

    public function getByBrokerId($brokerId)
    {
        
    }
    
    public function deleteByBrokerId($broker_id) {
        return BrokerageArea::where('broker_id', $broker_id)->delete();
    }
}