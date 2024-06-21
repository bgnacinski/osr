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
    protected $allowedFields    = ["identificator", "client", "tax_rate", "status", "created_by"];

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
//        "identificator" => "required|min_length[6]|max_length[50]|is_unique[bills.identificator]",
        "tax_rate" => "required|in_list[23,8,5,0]",
        "status" => "required|in_list[ok,pending,payment,returned]",
        "created_by" => "required|matches_users[users.login]"
    ];
    protected $validationMessages   = [
        "tax_rate" => [
            "required" => "Procent podatku VAT jest wymagana.",
            "in_list" => "Procent podatku VAT może przyjąć wartość 23%, 8%, 5% lub 0%."
        ],
        "status" => [
            "required" => "Pole statusu jest wymagane.",
            "in_list" => "Wartością pola statusu mogą być tylko ('ok', 'pending', 'payment', 'returned')."
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

    public function addBill(int $nip, int $tax_rate, string $status, string $created_by, array $bill_contents){
        $bill_contents_model = new BillEntryModel();
        $bill = new BillEntity();
        $bill->fill([
            "client" => $nip,
            "tax_rate" => $tax_rate,
            "status" => $status,
            "created_by" => $created_by
        ]);

        if($this->validate($bill)){
            foreach($bill_contents as $entry){
                $val_result = $bill_contents_model->validate($entry);

                if(!$val_result){
                    return [
                        "status" => "valerr",
                        "errors" => $bill_contents_model->errors()
                    ];
                }
            }

            $this->insert($bill);
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
