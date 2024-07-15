<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ReportEntity;
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

    public function add_page($job_id = null){
        if(is_null($job_id)){
            redirect("/panel/jobs")->with("success", 0)->with("message", "Nie znaleziono zlecenia z tym ID");
        }

        return view("reports/add");
    }

    public function add($job_id = null){
        if(is_null($job_id)){
            redirect()->to("/panel/jobs")->with("success", 0)->with("message", "Nie znaleziono zlecenia z tym ID.");
        }

        $report_content = $this->request->getPost("content");
        $report_files = $this->request->getFiles();

        $model = new ReportsModel();

        $report = new ReportEntity();
        $report->job_id = (int)$job_id;
        $report->content = $report_content;
        $report->created_by = $this->session->user->login;

        $val_result = $model->validate($report->toArray());

        if(!$val_result){
            $errors = $model->errors();

            return redirect()->to($_SERVER["HTTP_REFERER"])->with("success", 0)->with("errors", $errors);
        }

        $files = [];

        if($report_files){
            foreach ($report_files['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();

                    $filepath = WRITEPATH . 'uploads';

                    $file->move($filepath, $newName);

                    $files[] = $newName;
                }
            }
        }

        if(!empty($files)){
            $report->files = implode(",", $files);
        }
        else{
            $report->files = null;
        }

        $result = $model->addReport($report);

        switch($result["status"]){
            case "success":
                return redirect()->to("/panel/jobs/")->with("success", true)->with("message", "Dodano raport.");

            case "valerr":
                return redirect()->to($_SERVER["HTTP_REFERER"])->with("success", 0)->with("errors", $result["errors"]);
        }
    }

    public function show_file($identificator = null, $filename = null){
        if(is_null($identificator) || is_null($filename)){
            return redirect()->to($_SERVER["HTTP_REFERER"])->with("success", 0)->with("message", "Nie znaleziono pliku.");
        }

        helper("filesystem");
        $path = WRITEPATH . 'uploads/';

        $fullpath = $path . $filename;
        $file = new \CodeIgniter\Files\File($fullpath, true);
        $binary = readfile($fullpath);

        return $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($binary);
    }
}
