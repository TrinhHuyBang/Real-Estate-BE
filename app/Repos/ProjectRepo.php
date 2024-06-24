<?php
namespace App\Repos;

use App\Enums\ProjectStatus;
use App\Interfaces\ProjectRepoInterface;
use App\Models\Enterprise;
use App\Models\Project;
use App\Models\ProjectImage;

class ProjectRepo implements ProjectRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $project = Project::where('id', $id)->first();
        $images = ProjectImage::where('project_id', $project->id)->get();
        $imageUrls = [];
        foreach ($images as $image) {
            array_push($imageUrls, $image->url);
        }
        $investor = Enterprise::select(['id', 'name', 'logo', 'phone_number', 'email', 'address', 'website'])->where('id', $project->enterprise_id)->first();
        $count_project = '';

        $count_preparing_sale_project = Project::where('enterprise_id', $investor->id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::PREPARING_SALE)->count();
        if($count_preparing_sale_project) {
            $count_project = $count_project . $count_preparing_sale_project . ' sắp mở bán ';
        }
        
        $count_on_sale_project = Project::where('enterprise_id', $investor->id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::ON_SALE)->count();
        if($count_on_sale_project) {
            $count_project = $count_project . $count_on_sale_project . ' đang mở bán ';
        }

        $count_handed_over_project = Project::where('enterprise_id', $investor->id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::HANDED_OVER)->count();
        if($count_handed_over_project) {
            $count_project = $count_project . $count_handed_over_project . ' đã bàn giao ';
        }
        $investor->count_project = $count_project;

        $project->images = $imageUrls;
        $project->investor = $investor;
        return $project;
    }
    public function create($data)
    {
        return Project::create($data);
    }
    public function edit($id, $data)
    {
        $project = Project::where('id', $id)->first();
        $project->fill($data)->save();
        return $project;
    }
    public function delete($id)
    {
        $project = Project::where('id', $id)->first();
        if($project) {
            $project->update(['status' => config('status.project.deleted')]);
        }
        return $project;
    }

    // Lấy danh sách dự án theo các tiêu chí lọc của người dùng
    public function listProject($data) {
        $query = Project::select(['id', 'name', 'description', 'project_status', 'note', 'size', 'size_unit', 'start_price', 'end_price', 'address', 'apartment', 'building'])
        ->where('status', config('status.project.display'))
        ->where('name', 'like', '%' . $data['search'] . '%')
        ->where('province', 'like', '%' . $data['province'] . '%')
        ->where('district', 'like', '%' . $data['district'] . '%');
        if($data['status']) {
            $query->where('project_status', $data['status']);
        }
        if ($data['type_id']) {
            $query->where('type_id', $data['type_id']);
        }

        $startFilter = $data['startPrice'];
        $endFilter = $data['endPrice'];
        if($startFilter != 0 || $endFilter != 9999999999) {
            $query->where(function ($func) use ($startFilter, $endFilter) {
                $func->whereNotNull('start_price')
                    ->whereNull('end_price')
                    ->where('start_price', '>=', $startFilter)
                    ->where('start_price', '<=', $endFilter);
            })
            ->orWhere(function ($func) use ($startFilter, $endFilter) {
                $func->whereNotNull('start_price')
                    ->whereNotNull('end_price')
                    ->where('start_price', '<=', $endFilter)
                    ->where('end_price', '>=', $startFilter);
            });
        }
        $projects = $query->paginate(5);
        return $projects;
    }

    // Lấy danh sách dự án nổi bật
    public function listFavoriteProject() {
        $projects = Project::select(['id', 'name', 'project_status', 'note', 'size', 'size_unit', 'start_price', 'end_price', 'province', 'district', 'apartment', 'building'])
        ->where('status', config('status.project.display'))
        ->orderByDesc('number_views')
        ->limit(4)
        ->get();
        return $projects;
    }

    // Lấy danh sách dự án để cho vào ô chọn dự án dựa trên địa chỉ như thành phố và quận huyện
    public function listProjectOptions($data) {
        $projects = Project::select(['id', 'name', 'district', 'ward', 'street', 'address'])
        ->where('status', config('status.project.display'))
        ->where('province', 'like', '%' . $data['province'] . '%')
        ->where('district', 'like', '%' . $data['district'] . '%')
        ->get();
        
        return $projects;
    }

    // Lấy danh sách dự án của bản thân
    public function listOwnerProject($enterprise_id, $status, $project_status, $search) {
        $query = Project::select(['id', 'name', 'status', 'description', 'project_status', 'note', 'size', 'size_unit', 'start_price', 'end_price', 'address', 'apartment', 'building'])
        ->where('enterprise_id', $enterprise_id)
        ->where('name', 'like', '%' . $search . '%');

        if($status != config("status.project.all")) {
            $query->where('status', $status);
        }
        if($project_status != ProjectStatus::ALL) {
            if($project_status == ProjectStatus::UPDATING) {
                $query->whereNull('project_status');
            } else {
                $query->where('project_status', $project_status);
            }
        }
        $projects = $query->paginate(5);
        return $projects;
    }


    // Lấy danh sách dự án của 1 doanh nghiệp
    public function listProjectByEnterprise($enterprise_id) {
        $projects = Project::select(['id', 'name', 'description', 'project_status', 'note', 'size', 'size_unit', 'start_price', 'end_price', 'address', 'apartment', 'building'])
        ->where('enterprise_id', $enterprise_id)
        ->where('status', config("status.project.display"))
        ->get();
        foreach ($projects as $project) {
            $image = ProjectImage::where('project_id', $project->id)->first();
            $project->image = $image->url;
        }
        return $projects;
    }

    public function countProject() {
        return Project::where('status', config('status.project.display'))->count();
    }

    public function countRequest() {
        return Project::where('status', config('status.project.hidden'))->count();
    }

    public function listByStatus($search, $status) {
        $query = Project::select(['projects.*', 'project_images.url as image'])
        ->where('status', $status)
        ->join('project_images', function ($join) {
            $join->on('projects.id', '=', 'project_images.project_id')
                ->whereRaw('project_images.id = (select id from project_images where project_id = projects.id limit 1)');
        })
        ->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('projects.id', '=', $search);
            });
        $projects = $query->paginate(10);
        return $projects;
    }

    // lấy thông tin của dự án và tài khoản người dùng
    public function getInforById($id) {
        $project = Project::select(['projects.id', 'enterprises.user_id', 'projects.name'])
            ->where('projects.id', $id)
            ->leftJoin('enterprises', 'projects.enterprise_id', '=', 'enterprises.id')
            ->first();
        return $project; 
    }
}