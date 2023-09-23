<?php
namespace App\Repos;

use App\Interfaces\ProjectRepoInterface;
use App\Models\Project;

class ProjectRepo implements ProjectRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return Project::where('id', $id)->first();
    }
    public function create($data)
    {
        
    }
    public function edit($id, $data)
    {
        return Project::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }
}