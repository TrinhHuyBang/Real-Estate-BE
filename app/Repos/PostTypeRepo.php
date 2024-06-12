<?php
namespace App\Repos;

use App\Interfaces\PostTypeRepoInterface;
use App\Models\PostType;

class PostTypeRepo implements PostTypeRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return PostType::where('id', $id)->first();
    }
    public function create($data)
    {
        return PostType::create($data);
    }
    public function edit($id, $data)
    {
        return PostType::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }

    public function getByType($type) {
        $postTypes =  PostType::select('type')->where('type', 'like', '%' . $type. '%')->get();
        return $postTypes;
    }
}