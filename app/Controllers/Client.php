<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use CodeIgniter\HTTP\ResponseInterface;

class Client extends BaseController
{
    public function index(int $page = null)
    {
        $limit = 50;
        $model = new ClientModel();

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

        if(isset($_GET["nip"])){
            $nip = $_GET["nip"];

            $data = $model->like("nip", $nip)->findAll();
        }
        else {
            //fetching data
            if (is_null($page)) {
                $data = $model->orderBy("id", "DESC")->findAll($limit);
            } else {
                $offset = $page * $limit - $limit;
                $limit = $offset + $limit;

                $data = $model->orderBy("id", "DESC")->findAll($limit, $offset);
            }
        }

        if(empty($data)){
            $session = session();
            $session->setFlashdata("status", 0);
            $session->setFlashdata("message", "Brak rekordów");
        }

        $clients = $model->orderBy("id", "DESC")->findAll();

        return view("client/index", ["clients" => $clients, "page_data" => $page_data]);
    }

    public function add_page(){
        $model = new ClientModel();
        $clients = $model->findAll();

        return view("client/add", ["clients" => $clients]);
    }

    public function add(){
        $name = $this->request->getPost("name");
        $nip = $this->request->getPost("nip");
        $email = $this->request->getPost("email");
        $address = $this->request->getPost("first_address")."|".$this->request->getPost("second_address");

        $model = new ClientModel();
        $result = $model->addClient($name, $nip, $email, $address);

        switch($result["status"]){
            case "success":
                return redirect()->to("/panel/clients")->with("success", 1)->with("message", "Pomyślnie dodano klienta.");

            default:
                return redirect()->to("/panel/clients/add")->with("success", 0)->with("errors", $result["errors"]);
        }
    }
}
