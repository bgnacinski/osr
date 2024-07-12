<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobModel;
use App\Models\ReportsModel;
use CodeIgniter\HTTP\ResponseInterface;

class Jobs extends BaseController
{
    public function index($page = null)
    {
        $limit = 50;
        $model = new JobModel();

        // pagination
        $no_jobs = $model->countAllResults();

        if(round($no_jobs / $limit) < ($no_jobs / $limit)){
            $pages = round($no_jobs / $limit) + 1;
        }
        else{
            $pages = round($no_jobs / $limit);
        }

        $page = $page ?? 1;

        if($page == 1){
            $last_page = 1;
            $previous = "disabled";
        }
        else{
            $last_page = $page - 1;
            $previous = "";
        }

        if($page == $pages){
            $next_page = $page;
            $next = "disabled";
        }
        else{
            $next_page = $page + 1;
            $next = "";
        }

        $page_data = [
            "previous" => $previous,
            "next" => $next,
            "last_page" => $last_page,
            "next_page" => $next_page,
            "current" => $page,
            "available" => $pages
        ];

        if(isset($_GET["identificator"])){
            $identificator = $_GET["identificator"];

            $data = $model->like("identificator", $identificator)->findAll();
        }
        else{
            if (is_null($page)) {
                $data = $model->orderBy("id", "DESC")->findAll($limit);
            } else {
                $offset = $page * $limit - $limit;
                $limit = $offset + $limit;

                $data = $model->orderBy("id", "DESC")->findAll($limit, $offset);
            }
        }

        return view('jobs/index', ["page_data" => $page_data, "jobs" => $data]);
    }

    public function view($identificator = null){
        if(is_null($identificator)){
            return redirect()->to("/panel/jobs")->with("success", 0)->with("message", "Nie znaleziono określonego zlecenia.");
        }

        $job_model = new JobModel();
        $reports_model = new ReportsModel();

        $job_data = $job_model->getJob($identificator);

        if($job_data["status"] == "notfound"){
            return redirect()->to("/panel/jobs")->with("success", 0)->with("message", "Nie znaleziono określonego zlecenia.");
        }

        $reports = $reports_model->where("job_id", $job_data["data"]->id)->orderBy("id", "DESC")->findAll();

        $reports_data = [];
        $no_reports = count($reports);

        foreach($reports as $report){
            $reports_data[] = [
                "id" => $report->id,
                "preview" => substr($report->content, 0, 50),
                "date" => (string)$report->created_at
            ];
        }

        return view("jobs/view", ["job_data" => $job_data["data"], "no_reports" => $no_reports, "reports_data" => $reports_data]);
    }
}
