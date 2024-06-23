<?php
namespace App\Repos;

use App\Interfaces\ProjectImageRepoInterface;
use App\Models\ProjectImage;

class ProjectImageRepo implements ProjectImageRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return ProjectImage::where('id', $id)->first();
    }
    public function create($data)
    {
        return ProjectImage::create($data);
    }
    public function edit($id, $data)
    {
        return ProjectImage::where('id', $id)->update($data);
    }
    public function delete($project_id)
    {
        ProjectImage::where('project_id', $project_id)->delete();
    }

    public function getImageByProject($project_id) {
        $image = ProjectImage::where('project_id', $project_id)->first();
        return $image->url;
    }
}