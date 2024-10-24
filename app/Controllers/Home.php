<?php

namespace App\Controllers;

use App\Models\BillModel;
use App\Models\ClientModel;
use App\Models\JobModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        if(isset($_SERVER["HTTP_REFERER"])){
            redirect()->to($_SERVER["HTTP_REFERER"]);
        }

        $user = $this->session->user;

        switch($user->role){
            case "admin":
                return redirect()->to("/admin");
            
            case "manager":
                return redirect()->to("/manage");
            
            default:
                return redirect()->to("/panel");
        }
    }

    public function login_page(){
        if(isset($this->session->user)){
            $this->index();
        }

        return view("login");
    }

    public function login(){
        $login = $_POST["login"];
        $password = $_POST["password"];

        $model = new UserModel();

        $result = $model->login($login, $password);

        switch($result["success"]){
            case true:
                $this->session->set("user", $result["data"]);

                return redirect()->to("/");

            default:
                return redirect()->to("/login")->with("success", 0)->with("message", "Niepoprawny login lub hasło.");
        }
    }

    public function account_page(){
        $user = $this->session->get("user");

        return view("account", ["user" => $user]);
    }

    public function change_password_page(){
        $user = $this->session->get("user");

        return view("change_password", ["user" => $user]);
    }

    public function change_password(){
        $id = $this->session->user->id;
        $password_first = $this->request->getPost("password_first");
        $password_second = $this->request->getPost("password_second");

        $model = new UserModel();
        $result = $model->changePassword($id, $password_first, $password_second);

        switch($result["status"]){
            case "success":
                return redirect()->to("/account")->with("success", 1)->with("message", "Pomyślnie zmieniono hasło.");

            default:
                return redirect()->to("/account/change-password")->with("success", 0)->with("message", "Hasła nie są takie same.");
        }
    }

    public function logout(){
        $this->session->destroy();

        return redirect()->to("/");
    }

    public function panel(){
        $job_model = new JobModel();
        $job_data = [
            "count" => $job_model->countAllResults(),
            "ok" => $job_model->where("status", "ok")->countAllResults(),
            "done" => $job_model->where("status", "done")->countAllResults(),
            "payment" => $job_model->where("status", "payment")->countAllResults(),
            "pending" => $job_model->where("status", "pending")->countAllResults()
        ];

        $bill_model = new BillModel();
        $bill_data = [
            "count" => $bill_model->countAllResults()
        ];

        $client_model = new ClientModel();
        $client_data = [
            "count" => $client_model->countallResults()
        ];

        return view("panel", ["jobs" => $job_data, "bills" => $bill_data, "clients" => $client_data]);
    }
}
