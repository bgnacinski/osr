<?php

namespace App\Models;

use App\Entities\ReportEntity;
use CodeIgniter\Model;

class ReportsModel extends Model
{
    protected $table            = 'reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ReportEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["job_id", "content", "files", "number", "created_by"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "job_id" => "required|integer|matches_jobs[jobs.id]",
        "content" => "required|min_length[25]|max_length[1000]",
        "created_by" => "required|matches_users[users.login]"
    ];
    protected $validationMessages   = [
        "job_id" => [
            "required" => "ID zlecenia jest wymagane.",
            "integer" => "ID zlecenia musi być liczbą.",
            "matches" => "Zlecenie o podanym ID nie istnieje."
        ],
        "content" => [
            "required" => "Zawartość raportu jest wymagana.",
            "min_length" => "Zawartość raportu może mieć minimalnie 25 znaków.",
            "max_length" => "Zawartość raportu może mieć maksymalnie 1000 znaków."
        ],
        "created_by" => [
            "required" => "Podanie autora jest wymagane.",
            "matches_users" => "Autor nie znajduje się w bazie danych."
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["addNumber"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addNumber($data){
        $result = $this->where("job_id", $data["data"]["job_id"])->findAll();

        $number = count($result) + 1;

        $data["data"]["number"] = $number;

        return $data;
    }

    public function getReport($id){
        $result = $this->find($id);

        if(!is_null($result)){
            return [
                "status" => "success",
                "data" => $result
            ];
        }
        else{
            return [
                "status" => "notfound"
            ];
        }
    }
}
