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
    protected $allowedFields    = ["identificator", "client", "job_id", "bill_type", "discount", "discount_type", "created_by"];

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
        "client" => "required|min_length[10]|max_length[10]|integer|valid_nip|matches_clients[clients.nip]",
        "job_id" => "required|matches_identificator_jobs[jobs.identificator]",
        "bill_type" => "required|in_list[invoice,bill]",
        "discount" => "permit_empty|numeric",
        "discount_type" => "permit_empty|in_list[money,percentage]",
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
        "job_id" => [
            "required" => "Pole identyfikatora zlecenia jest wymagane.",
            "matches_identificator_jobs" => "Zlecenie o tym identyfikatorze nie znajduje się w bazie danych."
        ],
        "bill_type" => [
            "required" => "Typ rachunku jest wymagany.",
            "in_list" => "Typ rachunku musi mieć wartość 'rachunek' lub 'faktura'."
        ],
        "discount" => [
            "numeric" => "Wysokość rabatu musi być liczbą."
        ],
        "discount_type" => [
            "in_list" => "Typ rabatu może być pieniężny lub procentowy."
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

    public function addIdentificator($data): array{
        $index = $this->like("created_at", date("Y-m-d"))->countAllResults() + 1;

        $data["data"]["identificator"] = date("Y/m/d")."_".$index;
        
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

    public function addBill(int $nip, string $job_identificator, string $bill_type, int $discount, string $discount_type, string $created_by, array $bill_contents){
        $bill_contents_model = new BillEntryModel();

        $bill_data = [
            "client" => (string)$nip,
            "job_id" => $job_identificator,
            "bill_type" => $bill_type,
            "discount" => $discount,
            "discount_type" => $discount_type,
            "created_by" => $created_by
        ];

        $val_result = $this->validate($bill_data);

        if($val_result){
            foreach($bill_contents as $entry){
                $val_result = $bill_contents_model->validate($entry);

                if(!$val_result){
                    return [
                        "status" => "valerr",
                        "errors" => $bill_contents_model->errors()
                    ];
                }
            }

            $this->insert($bill_data);
            $result = $bill_contents_model->addBillEntries($this->getInsertID(), $bill_contents);

            return $result;
        }
        else{
            return [
                "status" => "valerr",
                "errors" => $this->errors()
            ];
        }
    }
}
