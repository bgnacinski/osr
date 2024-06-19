<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Couchbase\User;

class Admin extends BaseController
{
    public function index(int $page = null)
    {
        $limit = 30;
        $model = new UserModel();

        $no_users = $model->countAllResults();

        if(round($no_users / $limit) < ($no_users / $limit)){
            $pages = round($no_users / $limit) + 1;
        }
        else{
            $pages = round($no_users / $limit);
        }

        if(!isset($_GET["login"])){
            if(isset($page)) {
                $offset = $page * $limit - 30;
                $limit = $offset + 30;
                $data = $model->withDeleted()->findAll($limit, $offset);
            }
            else {
                $page = 1;
                $data = $model->withDeleted()->findAll($limit);
            }
        }
        else{
            $data = $model->like("login", $_GET["login"])->withDeleted()->findAll();
        }

        $page_data = [
            "current" => $page,
            "available" => $pages
        ];

        return view("admin/index", ["users" => $data, "page_data" => $page_data]);
    }

    public function add_page(){
        return view("admin/add");
    }

    public function add(){
        $name = $this->request->getPost("name");
        $login = $this->request->getPost("login");
        $password = $this->request->getPost("password");
        $role = $this->request->getPost("role");

        $model = new UserModel();
        $result = $model->newUser($name, $login, $password, $role);

        switch($result["status"]){
            case "success":
                return redirect()->to("/admin");

            default:
                var_dump($result);
                die;
                //return add_page($result["errors"]);
        }
    }

    public function edit_page(int $user_id = null){
        if(is_null($user_id)){
            return redirect()->to("/admin");
        }

        $model = new UserModel();
        $user = $model->find($user_id);

        return view("admin/edit", ["user" => $user]);
    }

    public function delete_page(int $user_id = null){
        if(is_null($user_id)){
            return redirect()->to("/admin");
        }

        $model = new UserModel();
        $user = $model->find($user_id);

        return view("admin/confirm", ["action" => "delete", "user" => $user]);
    }

    public function delete(int $user_id){
        $model = new UserModel();
        $result = $model->deleteUser($user_id);

        switch($result["status"]){
            case "success":
                $message = "Usunięcie użytkownika powiodło się";
                $success = 1;
                break;

            default:
                $message = "Usunięcie użytkownika nie powiodło się";
                $success = 0;
        }

        return redirect()->to("/admin")->with("success", $success)->with("message", $message);
    }

    public function restore_page(int $user_id){
        if(is_null($user_id)){
            return redirect()->to("/admin");
        }

        $model = new UserModel();
        $user = $model->withDeleted()->find($user_id);

        return view("admin/confirm", ["action" => "restore", "user" => $user]);
    }

    public function restore(int $user_id){
        if(is_null($user_id)){
            return redirect()->to("/admin");
        }

        $model = new UserModel();
        $result = $model->restoreUser($user_id);

        switch($result["status"]){
            case "success":
                $message = "Przywrócenie użytkownika powiodło się";
                $success = 1;
                break;

            default:
                $message = "Przywrócenie użytkownika nie powiodło się";
                $success = 0;
        }

        return redirect()->to("/admin")->with("success", $success)->with("message", $message);
    }
}
