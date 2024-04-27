<?php
namespace App\Repos;

use App\Enums\BrokerAdviceRequestStatus;
use App\Interfaces\BrokerRepoInterface;
use App\Models\Broker;
use App\Models\BrokerAdviceRequest;
use App\Models\BrokerageArea;
use App\Models\BrokerReview;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;

class BrokerRepo implements BrokerRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $broker = Broker::where('id', $id)->first();
        $broker->info = User::select(['name', 'phone', 'email', 'avatar'])->where('id', $broker->user_id)->first();
        $broker->areas = BrokerageArea::select(['type_id', 'province', 'district'])->where('broker_id', $broker->id)->get();
        $broker->count_posts = Post::where('user_id', $broker->user_id)->whereIn('status', [config('status.expired'), config('status.displayPost')])->count();
        $broker->number_consultations = BrokerAdviceRequest::where('broker_id', $broker->id)->whereIn('status', [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::DELETED])->count();
        $broker->rating = (float)number_format(BrokerReview::where('broker_id', $broker->id)
        ->avg('broker_reviews.rating'), 1);
        $broker->reviews = BrokerReview::select(['users.name', 'users.avatar', 'users.id', 'broker_reviews.review', 'broker_reviews.rating', 'broker_reviews.created_at'])
        ->leftJoin('users', 'users.id', '=', 'broker_reviews.user_id')
        ->where('broker_reviews.broker_id', $id)
        ->get();
        return $broker;
    }
    public function create($data)
    {
        $broker = new Broker();
        $broker->fill($data)->save();
        return $broker;
    }
    public function edit($id, $data)
    {
    }
    public function delete($id)
    {
        return Broker::where('id', $id)->delete();
    }

    public function listBroker($data)
    {
        $query = Broker::select('brokers.id')->distinct()
            ->leftJoin('users', 'brokers.user_id', '=', 'users.id')
            ->leftJoin('brokerage_areas', 'brokers.id', '=', 'brokerage_areas.broker_id')
            ->where('brokers.status', 1)
            ->where('users.status', 1)
            ->where('users.role', 3)
            ->where('users.name', 'like', '%'.$data['search'].'%');
        if(Arr::get($data, 'project_id')) {
            $query->where('brokerage_areas.project_id', Arr::get($data, 'project_id'));
        } else {
            $query->where('province', 'like', '%'.$data['province'].'%')
            ->where('district', 'like', '%'.$data['district'].'%');
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
        $brokerIds = $query->get();
        $brokers = Broker::whereIn('id', $brokerIds)->get();
        return $brokers;
    }

    public function getByUserId($userId) {
        $broker = Broker::select(['id'])->where('user_id', $userId)->first();
        return $broker;
    }

    public function getDetailByUserId($user_id) {
        $broker_infor = Broker::select(['id', 'address', 'description', 'certificate_url'])->where('user_id', $user_id)->first();
        $broker_infor->areas = BrokerageArea::select(['type_id', 'province', 'district'])->where('broker_id', $broker_infor->id)->get();
        return $broker_infor;
    }

    public function getBrokerDetail($broker) {
        $broker->info = User::select(['name', 'phone', 'email', 'avatar'])->where('id', $broker->user_id)->first();
        $broker->areas = BrokerageArea::select(['type_id', 'province', 'district'])->where('broker_id', $broker->id)->get();
        $broker->number_consultations = BrokerAdviceRequest::where('broker_id', $broker->id)->whereIn('status', [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::DELETED])->count();
        $broker->rating = (float)number_format(BrokerReview::where('broker_id', $broker->id)
        ->avg('broker_reviews.rating'), 1);
        return $broker;
    }

    public function updateByUserId($user_id, $data) {
        $broker = Broker::where('user_id', $user_id)->first();
        $broker->fill($data)->save();
        return $broker;
    }

    public function checkRegisteredByUserId($user_id) {
        $broker = Broker::where('user_id', $user_id)->where('status', 0)->first();
        return $broker ? true : false;
    }

}