<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{
    public function index(int $page = null)
    {
        $limit = 50;

        $model = new ProductModel();

        $no_products = $model->countAllResults();

        if(round($no_products / $limit) < ($no_products / $limit)){
            $pages = round($no_products / $limit) + 1;
        }
        else{
            $pages = round($no_products / $limit);
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

        $products = $model->findAll();

        return view("products/index", ["page_data" => $page_data, "products" => $products]);
    }
}
