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
        if(isset($_SERVER["HTTP_REFERER"])){
            $redirect_to = $_SERVER["HTTP_REFERER"];
        }
        else{
            $redirect_to = "/panel";
        }

        $db = \Config\Database::connect();
        $builder = $db->table("reports")
            ->select("reports.id, reports.content, reports.files, reports.number, reports.created_at, jobs.identificator, jobs.status, `users`.`name` as 'created_by'")
            ->join("jobs", "reports.job_id = jobs.id", "left")
            ->join("users", "reports.created_by = users.login", "left")
            ->where("reports.id", $id);
        $query = $builder->get();

        if($query->getFieldCount() > 1){
            $data = $query->getResult()[0];
        }
        else{
            return redirect()->to($redirect_to)->with("success", 0)->with("message", "Nie znaleziono określonego raportu.");
        }

        return view("reports/view", ["data" => $data]);
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

        $model = new ReportsModel();
        $report = $model->where("id", $identificator)->first();

        if(!in_array($filename, explode(",", $report->files))){
            return redirect()->to($_SERVER["HTTP_REFERER"])->with("success", 0)->with("message", "Nie masz dostępu do tego pliku.");
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
