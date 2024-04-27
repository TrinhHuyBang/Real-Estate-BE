<?php
namespace App\Repos;

use App\Enums\ProjectStatus;
use App\Interfaces\EnterpriseRepoInterface;
use App\Models\Enterprise;
use App\Models\Project;
use App\Models\SubField;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EnterpriseRepo implements EnterpriseRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $enterprise = Enterprise::select(['enterprises.id', 'address', 'enterprises.name', 'abbreviation', 'logo', 'phone_number', 'address', 'description', 'email', 'website', 'fields.name as main_field'])
        ->leftJoin('fields', 'enterprises.main_field', '=', 'fields.id')
        ->where('enterprises.id', $id) ->first();
        $sub_fields = SubField::leftJoin('fields', 'sub_fields.field_id', '=', 'fields.id')
        ->where('sub_fields.enterprise_id', $id)->get();
        $list_fields = [];
        foreach ($sub_fields as $sub_field) {
            $list_fields[] = $sub_field->name;
        }

        $enterprise->sub_fields = implode(', ', $list_fields);
        $count_handed_over_project = Project::where('enterprise_id', $id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::HANDED_OVER)->count();

        $count_on_sale_project = Project::where('enterprise_id', $id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::ON_SALE)->count();

        $count_preparing_sale_project = Project::where('enterprise_id', $id)->where('status', config('status.project.display'))
            ->where('project_status', ProjectStatus::PREPARING_SALE)->count();

        $enterprise->count_handed_over_project = $count_handed_over_project;
        $enterprise->count_on_sale_project = $count_on_sale_project;
        $enterprise->count_preparing_sale_project = $count_preparing_sale_project;
        return $enterprise;
    }
    public function create($data)
    {
        $enterprise = new Enterprise();
        $enterprise->fill($data)->save();
        return $enterprise;
    }
    public function edit($id, $data)
    {
    }
    public function delete($id)
    {
        return Enterprise::where('id', $id)->delete();
    }

    public function listEnterprise($data) {
        $query = Enterprise::select(['enterprises.id', 'address', 'name', 'abbreviation', 'logo', 'phone_number', 'address'])
            ->leftJoin('sub_fields', 'sub_fields.enterprise_id', '=', 'enterprises.id')
            ->where('enterprises.status', 1)
            ->where('address', 'like', '%'.$data['district'].'%')
            ->where('address', 'like', '%'.$data['province'].'%')
            ->where('name', 'like', '%'.$data['search'].'%')
            ->distinct();
            if(Arr::get($data, 'field')) {
                $field = Arr::get($data, 'field');
                $query->where(function ($func) use ($field) {
                    $func->where('enterprises.main_field', $field)
                    ->orWhere('sub_fields.field_id', $field);
                });
            }
        $enterprises = $query->paginate(10);
        return $enterprises;
    }

    public function getDetailByUserId($user_id) {
        $enterprise_infor = Enterprise::select(['id', 'name', 'abbreviation', 'description', 'logo', 'phone_number', 'email', 'address', 'website', 'main_field'])->where('user_id', $user_id)->first();
        $enterprise_infor->sub_field = SubField::select(['field_id'])->where('enterprise_id', $enterprise_infor->id)->get();
        return $enterprise_infor;
    }

    public function checkRegisteredByUserId($user_id) {
        $enterprise = Enterprise::where('user_id', $user_id)->where('status', 0)->first();
        return $enterprise ? true : false;
    }
}