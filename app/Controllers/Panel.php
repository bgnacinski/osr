<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BillEntryModel;
use App\Models\BillModel;
use App\Models\BillEntityModel;
use CodeIgniter\HTTP\ResponseInterface;

class Panel extends BaseController
{
    public function index(int $page = null)
    {
        $limit = 50;
        $model = new BillModel();

        // pagination
        $no_bills = $model->countAllResults();

        if(round($no_bills / $limit) < ($no_bills / $limit)){
            $pages = round($no_bills / $limit) + 1;
        }
        else{
            $pages = round($no_bills / $limit);
        }

        $page_data = [
            "current" => $page,
            "available" => $pages
        ];

        //processing search
        if(isset($_GET["identificator"])){
            $identificator = $_GET["identificator"];

            $data = $model->like("identificator", $identificator)->findAll();
        }
        else {
            //fetching data
            if (is_null($page)) {
                $data = $model->orderBy("id", "DESC")->findAll($limit);
            } else {
                $offset = $page * $limit - 30;
                $limit = $offset + 30;

                $data = $model->orderBy("id", "DESC")->findAll($limit, $offset);
            }
        }

        if(empty($data)){
            $session = session();
            $session->setFlashdata("status", 0);
            $session->setFlashdata("message", "Brak rekordów");
        }

        return view("panel/index", ["bills" => $data, "page_data" => $page_data]);
    }

    public function view(int $bill_id = null){
        if(is_null($bill_id)){
            return redirect()->to("/panel")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        $bill_model = new BillModel();
        $bill_contents_model = new BillEntryModel();

        $bill_data = $bill_model->getBill($bill_id);
        $bill_contents = $bill_contents_model->getBillContents($bill_id);

        if($bill_contents["status"] != "success" || $bill_data["status"] != "success"){
            return redirect()->to("/panel")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        return view("panel/view", ["bill_data" => $bill_data["data"], "bill_contents" => $bill_contents["data"]]);
    }

    public function add_page(){
        return view("panel/add");
    }
}
