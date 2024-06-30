<?php
namespace App\Repos;

use App\Enums\BrokerAdviceRequestStatus;
use App\Enums\BrokerRequestStatus;
use App\Interfaces\BrokerRepoInterface;
use App\Models\AdviceRequest;
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
        $broker->areas = BrokerageArea::select(['brokerage_areas.type_id', 'projects.name as project_name', 'brokerage_areas.province', 'brokerage_areas.district'])
        ->leftJoin('projects', 'projects.id', '=', 'brokerage_areas.project_id')
        ->where('broker_id', $broker->id)->get();
        $broker->count_posts = Post::where('user_id', $broker->user_id)->whereIn('status', [config('status.expired'), config('status.displayPost')])->count();
        $broker->number_consultations = BrokerAdviceRequest::where('broker_id', $broker->id)->whereIn('status', [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::DELETED])->count();
        $broker->rating = (float)number_format(BrokerReview::where('broker_id', $broker->id)
        ->avg('broker_reviews.rating'), 1);

        return $broker;
    }

    public function createOrUpdate($user_id, $data)
    {
        $broker = Broker::updateOrCreate(
            ['user_id' => $user_id, 'status' => BrokerRequestStatus::APPLIED],
            $data
        );
        return $broker;
    }

    public function create($data)
    {
        return Broker::create($data);
    }
    public function edit($id, $data)
    {
        $broker = Broker::findOrFail($id);
        $broker->fill($data)->save();
        return $broker;
    }
    public function delete($id)
    {
        return Broker::destroy($id);
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

    public function getDetailRegistration($user_id)
    {
        $broker = Broker::where('user_id', $user_id)->where('status', BrokerRequestStatus::APPLIED)->first();
        $broker->areas = BrokerageArea::select(['brokerage_areas.type_id', 'projects.name as project_name', 'brokerage_areas.province', 'brokerage_areas.district'])
        ->leftJoin('projects', 'projects.id', '=', 'brokerage_areas.project_id')
        ->where('broker_id', $broker->id)->get();
        return $broker;
    }

    public function getUserDetail($broker_id) {
        return Broker::select(['users.name', 'users.email', 'users.phone'])
        ->join('users', 'brokers.user_id', '=', 'users.id')
        ->where('brokers.id', '=', $broker_id)
        ->first();
    }

    public function getByUserId($userId)
    {
        return Broker::select('id')->where('user_id', $userId)->first();
    }

    public function getDetailByUserId($user_id) {
        $broker_infor = Broker::select(['id', 'address', 'description', 'certificate_url'])->where('user_id', $user_id)->first();
        $broker_infor->areas = BrokerageArea::select(['brokerage_areas.type_id', 'projects.name as project_name', 'brokerage_areas.province', 'brokerage_areas.district'])
        ->leftJoin('projects', 'projects.id', '=', 'brokerage_areas.project_id')
        ->where('broker_id', $broker_infor->id)->get();
        return $broker_infor;
    }

    public function getBrokerDetail($broker, $broker_request_id = null)
    {
        $broker->info = User::select(['name', 'phone', 'email', 'avatar'])->find($broker->user_id);
        $broker->areas = BrokerageArea::select(['brokerage_areas.type_id', 'projects.name as project_name', 'brokerage_areas.province', 'brokerage_areas.district'])
        ->leftJoin('projects', 'projects.id', '=', 'brokerage_areas.project_id')
        ->where('broker_id', $broker->id)->get();
        if($broker_request_id) {
            $isRating = BrokerReview::where('broker_request_id', $broker_request_id)->first();
            $broker->isRating = $isRating ? $isRating->rating : 0;
        }
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
        $broker = Broker::where('user_id', $user_id)->where('status', BrokerRequestStatus::APPLIED)->first();
        return $broker ? true : false;
    }

    public function listBrokerForAdmin($data, $status)
    {
        $query = Broker::select(['brokers.*', 'users.avatar', 'users.name', 'users.email', 'users.phone', 'users.status as account_status'])
            ->leftJoin('users', 'brokers.user_id', '=', 'users.id')
            ->where('brokers.status', $status)
            ->where(function ($query) use ($data){
                if(Arr::get($data, 'search')) {
                    $query->where('email', Arr::get($data, 'search'))
                    ->orWhere('phone', Arr::get($data, 'search'));
                } else {
                    $query->where('email', 'like', '%' . Arr::get($data, 'search') . '%');
                }
            });
        $brokers = $query->paginate(10);
        foreach ($brokers as $broker) {
            $broker->areas = BrokerageArea::select(['brokerage_areas.type_id', 'projects.name as project_name', 'brokerage_areas.province', 'brokerage_areas.district'])
            ->leftJoin('projects', 'projects.id', '=', 'brokerage_areas.project_id')
            ->where('broker_id', $broker->id)->get();
        }
        return $brokers;
    }

    public function listReview($broker_id)
    {
        $reviews = BrokerReview::select([
                'users.name',
                'users.avatar',
                'users.id as user_id',
                'broker_reviews.broker_request_id',
                'broker_reviews.review',
                'broker_reviews.rating',
                'broker_reviews.created_at'
            ])
            ->join('users', 'users.id', '=', 'broker_reviews.user_id')
            ->where('broker_reviews.broker_id', $broker_id)
            ->orderBy('broker_reviews.created_at', 'desc')
            ->paginate(15);
        foreach ($reviews as $review) {
            $review->advice_request = AdviceRequest::select('advice_requests.*')
            ->join('broker_advice_requests', 'broker_advice_requests.request_id', '=', 'advice_requests.id')
            ->where('broker_advice_requests.id', $review->broker_request_id)
            ->first();
        }
        return $reviews;
    }

    public function blockAccount($id)
    {
        $broker = Broker::findOrFail($id);
        $user = User::findOrFail($broker->user_id);
        $user->status = !$user->status;
        $user->save();
        return $user->status ? 'Mở khoá tài khoản thành công' : 'Khoá tài khoản thành công';
    }

    public function countBroker()
    {
        return Broker::where('status', 1)->count();
    }

    public function countRequest()
    {
        return Broker::where('status', 0)->count();
    }
}