<?php
namespace App\Repos;

use App\Enums\BrokerAdviceRequestStatus;
use App\Interfaces\BrokerAdviceRequestRepoInteface;
use App\Models\Broker;
use App\Models\BrokerAdviceRequest;
use App\Models\BrokerageArea;
use App\Models\User;

class BrokerAdviceRequestRepo implements BrokerAdviceRequestRepoInteface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        $brokerAdviceRequest = new BrokerAdviceRequest();
        $brokerAdviceRequest->fill($data)->save();
        return $brokerAdviceRequest;
    }
    public function edit($id, $data)
    {
        $brokerAdviceRequest = BrokerAdviceRequest::where('id', $id)->first();
        $brokerAdviceRequest->fill($data)->save();
        return $brokerAdviceRequest;
    }
    public function delete($id)
    {
        return BrokerAdviceRequest::where('id', $id)->delete();
    }

    public function editStatus($request_id, $broker_id, $status)
    {
        $brokerAdviceRequest = BrokerAdviceRequest::where('request_id', $request_id)->where('broker_id', $broker_id)->first();
        $brokerAdviceRequest->fill(['status' => $status])->save();
        return $brokerAdviceRequest;
    }

    public function getByRequestIdAndStatus($request_id, array $status = []) {
        $brokerAdviceRequests = BrokerAdviceRequest::where('request_id', $request_id)->whereIn('status', $status)->get();
        return $brokerAdviceRequests;
    }

    public function getByRequestIdAndBrokerId($request_id, $broker_id) {
        $brokerAdviceRequest = BrokerAdviceRequest::where('request_id', $request_id)->where('broker_id', $broker_id)->first();
        return $brokerAdviceRequest;
    }

    public function getAvatarBroker($request_id) {
        $avatar = User::select('users.avatar')
            ->join('brokers', 'brokers.user_id', '=', 'users.id')
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->whereIn('broker_advice_requests.status', [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::APPLIED])
            ->value('users.avatar');
        return $avatar;
    }

    public function getBrokerAccepted($request_id) {
        $broker = Broker::select(['brokers.id', 'brokers.address', 'brokers.user_id', 'broker_advice_requests.id as broker_request_id'])
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->where('broker_advice_requests.status', BrokerAdviceRequestStatus::ACCEPTED)
            ->first();
        return $broker;
    }

    public function listRequestByBroker($broker_id) {
        $requestIds = BrokerAdviceRequest::where('broker_id', $broker_id)->pluck('request_id')->toArray();
        return $requestIds;
    }

    public function listBrokerApplied($request_id) {
        $broker = Broker::select(['brokers.id', 'brokers.address', 'brokers.user_id'])
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->where('broker_advice_requests.status', BrokerAdviceRequestStatus::APPLIED)
            ->paginate(5);
        return $broker;
    }
}