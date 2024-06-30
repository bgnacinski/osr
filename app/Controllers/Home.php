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
}
