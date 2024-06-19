<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
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
                return view("login", ["success" => false]);
        }
    }
}
