<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BillEntity extends Entity
{
    protected $datamap = [
        "id" => "id",
        "identificator" => "identificator",
        "client" => "client",
        "status" => "status",
        "tax_rate" => "tax_rate",
        "created_by" => "created_by"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
