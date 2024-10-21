<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BillEntryModel;
use App\Models\BillModel;
use App\Models\BillEntityModel;
use App\Models\ClientModel;
use App\Models\JobModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Bills extends BaseController
{
    public function index(int $page = null)
    {
        $limit = 30;
        $model = new BillModel();

        $db = \Config\Database::connect();

        // pagination
        $no_bills = $model->countAllResults();

        if(round($no_bills / $limit) < ($no_bills / $limit)){
            $pages = round($no_bills / $limit) + 1;
        }
        else{
            $pages = round($no_bills / $limit);
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

        //processing search
        if(isset($_GET["identificator"])){
            $identificator = $_GET["identificator"];

            $builder = $db->table('bills')
                ->select("`jobs`.`identificator` as 'identificator', bills.id, bills.created_at, bills.updated_at, bills.deleted_at")
                ->join("jobs", "bills.job_id = jobs.identificator", "left")
                ->like("bills.job_id", $identificator);
            $query = $builder->get();
        }
        else if(isset($_GET["client"])){
            $client = $_GET["client"];

            $builder = $db->table('bills')
                ->select("jobs.identificator as 'identificator', bills.id, bills.created_at, bills.updated_at, bills.deleted_at")
                ->join("jobs", "bills.job_id = jobs.identificator", "left")
                ->like("bills.client", $client)
                ->orderBy("bills.id", "DESC");
            $query = $builder->get();
        }
        else {
            $offset = $page * $limit - $limit;
            $limit = $offset + $limit;

            $builder = $db->table('bills')
                ->select("jobs.identificator as 'identificator', bills.id, bills.created_at, bills.updated_at, bills.deleted_at")
                ->join("jobs", "bills.job_id = jobs.identificator", "left")
                ->orderBy("bills.id", "DESC")
                ->limit($limit, $offset);
            $query = $builder->get();
        }

        $data = $query->getResult();

        if(empty($data)){
            $session = session();
            $session->setFlashdata("status", 0);
            $session->setFlashdata("message", "Brak rekordów");
        }

        return view("bills/index", ["bills" => $data, "page_data" => $page_data]);
    }

    public function view(int $bill_id = null){
        if(is_null($bill_id)){
            return redirect()->to("/panel/bills")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        $db = \Config\Database::connect();
        $builder = $db->table('bills')
            ->select("bills.identificator, bills.client, bills.tax_rate, bills.created_at, `clients`.`name` as 'client_name', `clients`.`address` as 'client_address', `users`.`name` as 'worker_name'")
            ->join("users", "bills.created_by = users.login", "left")
            ->join("clients", "bills.client = clients.nip", "left")
            ->where("bills.id", $bill_id);
        $query = $builder->get();

        if($query->getFieldCount() > 0){
            $bill_data = $query->getResult()[0];

            $bill_contents_model = new BillEntryModel();
            $bill_contents = $bill_contents_model->getBillContents($bill_id);
        }
        else{
            return redirect()->to("/panel/bills")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        if($bill_contents["status"] != "success"){
            return redirect()->to("/panel")->with("success", 0)->with("message", "Nie znaleziono określonego rachunku.");
        }

        return view("bills/view", ["bill_data" => $bill_data, "bill_contents" => $bill_contents["data"]]);
    }

    public function add_page($job_identificator = null){
        if(is_null($job_identificator)){
            return redirect()->back()->with("success", 0)->with("message", "Nie znaleziono określonego zlecenia.");
        }

        $product_model = new ProductModel();
        $products = $product_model->findAll();

        $job_model = new JobModel();
        $job = $job_model->getJob($job_identificator);

        if($job["status"] != "success"){
            return redirect()->back()->with("success", 0)->with("message", "Nie znaleziono określonego zlecenia.");
        }

        return view("bills/add", ["products" => $products, "job" => $job["data"]]);
    }

    public function add($job_identificator = null){
        if(is_null($job_identificator)){
            return redirect()->back()->with("success", 0)->with("message", "Nie znaleziono określonego zlecenia.");
        }

        $nip = (int)$this->request->getPost("client") ?? null;
        $tax_rate = $this->request->getPost("tax_rate") ?? null;
        $discount = (int)$this->request->getPost("discount") ?? null;
        $discount_type = $this->request->getPost("discount_type") ?? null;
        $bill_contents_dump = $this->request->getPost("bill_contents") ?? null;

        $bill_contents = [];

        $bill_contents_dump = explode(";", $bill_contents_dump);
        array_pop($bill_contents_dump);

        foreach($bill_contents_dump as $element){
            $element = explode(",", $element);

            $bill_contents[] = $element;
        }

        $created_by = $this->session->user->login;

        $model = new BillModel();
        $result = $model->addBill($nip, $job_identificator, $tax_rate, $discount, $discount_type, $created_by, $bill_contents);

        switch($result["status"]){
            case "success":
                $job_model = new JobModel();
                $job_model->changeStatus($job_identificator, "payment");

                $bill_id = $model->getInsertID();

                return redirect()->to("/panel/bills/view/$bill_id")->with("success", 1)->with("message", "Pomyślnie dodano rachunek");

            default:
                return redirect()->back()->with("success", 0)->with("errors", $model->errors());
        }
    }
}
