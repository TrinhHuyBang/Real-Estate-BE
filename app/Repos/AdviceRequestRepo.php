<?php
namespace App\Repos;

use App\Interfaces\AdviceRequestRepoInterface;
use App\Models\AdviceRequest;
use Illuminate\Support\Arr;

class AdviceRequestRepo implements AdviceRequestRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $adviceRequest = AdviceRequest::where('id', $id)->first();
        return $adviceRequest;
    }
    public function create($data)
    {
        $adviceRequest = new AdviceRequest();
        $adviceRequest->fill($data)->save();
        return $adviceRequest;
    }
    public function edit($id, $data)
    {
        $adviceRequest = AdviceRequest::where('id', $id)->first();
        $adviceRequest->fill($data)->save();
        return $adviceRequest;
    }
    public function delete($id)
    {
        return AdviceRequest::where('id', $id)->delete();
    }

    public function getList()
    {
        
    }

    public function listByStatus($status, $postType, $search = '')
    {
        if ($status == config('requestStatus.all')) {
            $adviceRequests = AdviceRequest::where('user_id', auth()->user()->id)->whereIn('type_id', $postType)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                })->paginate(10);
        } else {
            $adviceRequests = AdviceRequest::where('user_id', auth()->user()->id)->whereIn('type_id', $postType)->where('status', $status)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                })->paginate(10);
        }
        return $adviceRequests;
    }

    public function listByBroker($broker_id, $except, $data)
    {
        $query = AdviceRequest::join('brokerage_areas', function ($join) {
            $join->on('brokerage_areas.type_id', '=', 'advice_requests.type_id')
                ->whereColumn('brokerage_areas.province', '=', 'advice_requests.province')
                ->whereColumn('brokerage_areas.district', '=', 'advice_requests.district');
        })
        ->select('advice_requests.*')
        ->where('brokerage_areas.broker_id', $broker_id)
        ->where('advice_requests.status', config('requestStatus.displaying'))
        ->whereNotIn('advice_requests.id', $except)
        ->where('advice_requests.title', 'like', '%'.$data['search'].'%');

        if(Arr::get($data, 'project_id')) {
            $query->where('advice_requests.project_id', Arr::get($data, 'project_id'));
        } else {
            $query->where('advice_requests.province', 'like', '%'.$data['province'].'%')
            ->where('advice_requests.district', 'like', '%'.$data['district'].'%');
        }

        if (!$data['type_id']) {
            if ($data['type'] === 'sell') {
                $query->whereIn('brokerage_areas.type_id', config('postType.sell'));
            } else if ($data['type'] === 'rent') {
                $query->whereIn('brokerage_areas.type_id', config('postType.rent'));
            }
        } else {
            $query->where('brokerage_areas.type_id', $data['type_id']);
        }
        $matchedRequests = $query->paginate(10);
        return $matchedRequests;
    }

    public function listAppliedRequestByBrokerId($broker_id, $status, $postType, $search)
    {
        $query = AdviceRequest::select(['advice_requests.*', 'broker_advice_requests.status as applied_status', 'broker_reviews.rating'])
            ->leftJoin('broker_advice_requests', 'broker_advice_requests.request_id', '=', 'advice_requests.id')
            ->leftJoin('broker_reviews', 'broker_reviews.broker_request_id', '=', 'broker_advice_requests.id')
            ->where('advice_requests.status', config('requestStatus.displaying'))
            ->where('broker_advice_requests.broker_id', $broker_id)->whereIn('type_id', $postType)
            ->where(function ($func) use ($search) {
                $func->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        if($status != config('brokerAdviceRequestStatus.ALL')) {
            $query->where('broker_advice_requests.status', $status);
        }
        $adviceRequests = $query->paginate(10);
        return $adviceRequests;
    }
}