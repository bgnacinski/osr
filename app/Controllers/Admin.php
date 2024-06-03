<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

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
                $data = $model->findAll($limit, $offset);
            }
            else {
                $page = 1;
                $data = $model->findAll($limit);
            }
        }
        else{
            $data = $model->like("login", $_GET["login"])->findAll();
        }


        $page_data = [
            "current" => $page,
            "available" => $pages
        ];

        return view("admin/index", ["users" => $data, "page_data" => $page_data]);
    }
}
