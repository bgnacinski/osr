<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobModel;
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
}
