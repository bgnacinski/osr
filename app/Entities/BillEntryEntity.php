<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BillEntryEntity extends Entity
{
    protected $datamap = [
        "id" => "id",
        "bill_id" => "bill_id",
        "product_name" => "product_name",
        "quantity" => "quantity",
        "created_at" => "created_at",
        "updated_at" => "updated_at",
        "deleted_at" => "deleted_at"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
