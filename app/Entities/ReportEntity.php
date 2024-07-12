<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ReportEntity extends Entity
{
    protected $datamap = [
        "job_id" => "job_id",
        "content" => "content",
        "files" => "files"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
