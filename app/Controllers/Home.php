<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
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
