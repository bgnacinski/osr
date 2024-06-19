<?php

namespace App\Models;

use App\Entities\BillEntity;
use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table            = 'bills';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = BillEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["identificator", "status", "created_by"];

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
        "identificator" => "required|min_length[6]|max_length[50]|is_unique_with_deleted[bills.identificator]",
        "status" => "required|in_list[ok,pending,payment,returned]",
        "created_by" => "required|matches[users.name]"
    ];
    protected $validationMessages   = [
        "identificator" => [
            "required" => "Identyfikator zamówienia jest wymagany.",
            "min_length" => "Minimalna długość identyfikatora to 6 znaków.",
            "max_lenght" => "Maksymalna długość identyfikatora to 50 znaków."
        ],
        "status" => [
            "required" => "Pole statusu jest wymagane.",
            "in_list" => "Wartością pola statusu mogą być tylko ('ok', 'pending', 'payment', 'returned')."
        ],
        "created_by" => [
            "required" => "Podanie autora jest wymagane.",
            "matches" => "Autor nie znajduje się w bazie danych."
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [
        "addIdentificator"
    ];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addIdentificator($data): array{
        $hash_data = (string)time().random_bytes(15);

        $hash = hash("sha512", $hash_data);

        $data["data"]["identificator"] = env("company.prefix")."_".substr($hash, 0, 15);
        
        return $data;
    }

    public function getBill(int $id){
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
