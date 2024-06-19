<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ClientEntity extends Entity
{
    protected $datamap = [
        "company" => "company",
        "nip" => "nip",
        "email" => "email"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
