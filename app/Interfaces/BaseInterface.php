<?php
namespace App\Interfaces;

interface BaseInterface
{
    public function get($id);
    public function create($data);
    public function edit($id, $data);
    public function delete($id);
}