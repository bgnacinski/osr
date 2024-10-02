<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductEntity extends Entity
{
    protected $datamap = [
        "friendly_id" => "friendly_id",
        "name" => "name",
        "description" => "description",
        "amount" => "amount",
        "tax_rate" => "tax_rate"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
