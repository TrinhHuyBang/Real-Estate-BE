<?php
namespace App\Repos;

use App\Interfaces\ReportRepoInterface;
use App\Models\Report;

class ReportRepo implements ReportRepoInterface
{
    public function getInstance($fields = ['*'])
    {
        $reports = Report::select($fields)->get();
        return $reports;
    }
    public function get($name)
    {
        return report::where('name', $name)->first();
    }
    public function create($data)
    {
        $report = new Report();
        $report->fill($data)->save();
        return $report;
    }
    public function edit($id, $data)
    {
        return Report::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return Report::where('id', $id)->delete();
    }

    // Lấy danh sách các đánh giá theo trạng thái
    public function listByStatus($status)
    {
        return Report::where('status', $status)->orderBy('created_at', 'desc')->paginate(15);
    }
}