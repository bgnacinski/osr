<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BillEntryModel;
use App\Models\BillModel;
use App\Models\BillEntityModel;
use App\Models\ProductModel;
use App\Models\UserModel;
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

        $user_model = new UserModel();
        $bill_data["data"]->created_by = $user_model->getUser($bill_data["data"]->created_by)->name;

        if($bill_contents["status"] != "success" || $bill_data["status"] != "success"){
            return redirect()->to("/panel")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        return view("panel/view", ["bill_data" => $bill_data["data"], "bill_contents" => $bill_contents["data"]]);
    }

    public function add_page(){
        $product_model = new ProductModel();

        $products = $product_model->findAll();

        return view("panel/add", ["products" => $products]);
    }

    public function add(){
        $nip = (int)$this->request->getPost("nip");
        $tax_rate = (int)$this->request->getPost("tax_rate");
        $status = $this->request->getPost("status");
        $bill_contents_dump = $this->request->getPost("bill_contents");

        $bill_contents = [];

        $bill_contents_dump = explode(";", $bill_contents_dump);
        array_pop($bill_contents_dump);

        foreach($bill_contents_dump as $element){
            $element = explode(",", $element);

            $bill_contents[] = $element;
        }

        $session = \Config\Services::session();
        $created_by = $session->user->login;

        $model = new BillModel();
        $result = $model->addBill($nip, $tax_rate, $status, $created_by, $bill_contents);

        return redirect()->to("/panel")->with("success", 1)->with("message", "Pomyślnie dodano rachunek");
    }
}
