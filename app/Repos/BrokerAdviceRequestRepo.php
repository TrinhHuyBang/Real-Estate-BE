<?php
namespace App\Repos;

use App\Enums\BrokerAdviceRequestStatus;
use App\Interfaces\BrokerAdviceRequestRepoInteface;
use App\Models\Broker;
use App\Models\BrokerAdviceRequest;
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
        return BrokerAdviceRequest::create($data);
    }
    public function edit($id, $data)
    {
        $brokerAdviceRequest = BrokerAdviceRequest::findOrFail($id);
        $brokerAdviceRequest->fill($data)->save();
        return $brokerAdviceRequest;
    }
    public function delete($id)
    {
        return BrokerAdviceRequest::destroy($id);
    }

    public function editStatus($request_id, $broker_id, $status)
    {
        $brokerAdviceRequest = BrokerAdviceRequest::where('request_id', $request_id)
            ->where('broker_id', $broker_id)
            ->firstOrFail();

        $brokerAdviceRequest->update(['status' => $status]);
        return $brokerAdviceRequest;
    }

    public function getByRequestIdAndStatus($request_id, array $status = [])
    {
        return BrokerAdviceRequest::where('request_id', $request_id)
            ->whereIn('status', $status)
            ->get();
    }

    public function getByRequestIdAndBrokerId($request_id, $broker_id)
    {
        return BrokerAdviceRequest::where('request_id', $request_id)
            ->where('broker_id', $broker_id)
            ->first();
    }

    public function getAvatarBroker($request_id)
    {
        return User::select('users.avatar')
            ->join('brokers', 'brokers.user_id', '=', 'users.id')
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->whereIn('broker_advice_requests.status', [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::APPLIED])
            ->value('users.avatar');
    }

    public function getBrokerAccepted($request_id)
    {
        return Broker::select(['brokers.id', 'brokers.address', 'brokers.user_id', 'broker_advice_requests.id as broker_request_id'])
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->where('broker_advice_requests.status', BrokerAdviceRequestStatus::ACCEPTED)
            ->first();
    }

    public function listRequestByBroker($broker_id)
    {
        return BrokerAdviceRequest::where('broker_id', $broker_id)
            ->pluck('request_id')
            ->toArray();
    }

    public function listBrokerApplied($request_id)
    {
        return Broker::select(['brokers.id', 'brokers.address', 'brokers.user_id'])
            ->join('broker_advice_requests', 'broker_advice_requests.broker_id', '=', 'brokers.id')
            ->where('broker_advice_requests.request_id', $request_id)
            ->where('broker_advice_requests.status', BrokerAdviceRequestStatus::APPLIED)
            ->paginate(5);
    }
}