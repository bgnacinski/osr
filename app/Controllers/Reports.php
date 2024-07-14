<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobModel;
use App\Models\ReportsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Reports extends BaseController
{
    public function index()
    {
        //
    }

    public function view($id = null){
        $reports_model = new ReportsModel();
        $result = $reports_model->getReport($id);

        if(isset($_SERVER["HTTP_REFERER"])){
            $redirect_to = $_SERVER["HTTP_REFERER"];
        }
        else{
            $redirect_to = "/panel";
        }

        if($result["status"] != "success"){
            return redirect()->to($redirect_to)->with("success", 0)->with("message", "Nie znaleziono określonego raportu.");
        }

        $report_data = $result["data"];

        $jobs_model = new JobModel();
        $job_data = $jobs_model->find($report_data->job_id);

        $users_model = new UserModel();
        $report_data->created_by = $users_model->where("login", $report_data->created_by)->first()->name;

        return view("reports/view", ["report_data" => $result["data"], "job_data" => $job_data]);
    }
}
