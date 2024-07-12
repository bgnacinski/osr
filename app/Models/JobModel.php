<?php

namespace App\Models;

use App\Entities\JobEntity;
use CodeIgniter\Model;

class JobModel extends Model
{
    protected $table            = 'jobs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = JobEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["identificator", "client", "status", "description", "comment", "created_by"];

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
        "client" => "required|matches_clients[clients.nip]|min_length[10]|max_length[10]|integer|valid_nip",
        "status" => "required|in_list[ok,pending,payment]",
        "description" => "required|min_length[5]|max_length[500]",
        "comment" => "max_length[500]",
        "created_by" => "required|matches_users[users.login]"
    ];
    protected $validationMessages   = [
        "client" => [
            "required" => "NIP jest wymagany.",
            "min_length" => "NIP musi składać się z 10 znaków.",
            "max_length" => "NIP musi składać się z 10 znaków.",
            "integer" => "NIP musi być numerem.",
            "valid_nip" => "NIP jest niepoprawny.",
            "matches_clients" => "Podany NIP nie jest powiązany z żadnym klientem."
        ],
        "status" => [
            "required" => "Pole statusu jest wymagane.",
            "in_list" => "Wartością pola statusu mogą być tylko ('ok', 'pending', 'payment', 'returned')."
        ],
        "description" => [
            "required" => "Opis zlecenia jest wymagany.",
            "min_length" => "Minimalna długość opisu to 5 znaków.",
            "max_length" => "Maksymalna długość opisu to 500 znaków."
        ],
        "comment" => [
            "max_length" => "Maksymalna długość komentarza to 500 znaków."
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

    public function addIdentificator(array $data): array{
        $seed = random_bytes(15).(string)time();
        $hash = hash("sha512", $seed);

        $data["data"]["identificator"] = substr($hash, 0, 15);

        return $data;
    }

    public function getJob(string $identificator){
        $result = $this->where("identificator", $identificator)->first();

        if($result){
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
