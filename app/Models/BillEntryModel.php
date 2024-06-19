<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\BillEntryEntity;

class BillEntryModel extends Model
{
    protected $table            = 'bill_contents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = BillEntryEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["bill_id", "product_name", "quantity"];

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
        "bill_id" => "required|matches[bills.id]",
        "product_name" => "required|matches[products.name]",
        "quantity" => "required|numeric|greater_than[0]"
    ];
    protected $validationMessages   = [
        "bill_id" => [
            "required" => "ID rachunku jest wymagane.",
            "matches" => "Rachunek z tym ID nie istnieje w bazie danych."
        ],
        "product_name" => [
            "required" => "Nazwa produktu jest wymagana",
            "matches" => "Produkt o tej nazwie nie istnieje w bazie danych"
        ],
        "quantity" => [
            "required" => "Ilość jest wymagana",
            "integer" => "Ilość musi być liczbą całkowitą",
            "greater_than" => "Ilość musi być większy od 0"
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getBillContents($bill_id){
        $result = $this->where("bill_id", $bill_id)->findAll();

        $model = new ProductModel();

        if(!is_null($result)){
            $data = [];

            foreach($result as $entry){
                $name = $entry->product_name;
                $quantity = $entry->quantity;

                $product = $model->where("name", $name)->first();
                $amount = $product->amount;
                $description = $product->description;

                $total = $quantity * $amount;

                $data[] = [
                    "name" => $name,
                    "description" => $description,
                    "quantity" => $quantity,
                    "amount" => $amount,
                    "total" => $total
                ];
            }

            return [
                "status" => "success",
                "data" => $data
            ];
        }
        else{
            return [
                "status" => "notfound"
            ];
        }
    }
}
