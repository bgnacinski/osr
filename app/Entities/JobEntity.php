<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class JobEntity extends Entity
{
    protected $datamap = [
        "identificator" => "identificator",
        "client" => "client",
        "status" => "status",
        "description" => "description",
        "comment" => "comment",
        "created_by" => "created_by"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
