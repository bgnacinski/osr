<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BillEntryEntity extends Entity
{
    protected $datamap = [
        "id" => "id",
        "bill_id" => "bill_id",
        "product_name" => "product_name",
        "description" => "description",
        "quantity" => "quantity",
        "price" => "price"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
