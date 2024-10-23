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
    protected $allowedFields    = ["bill_id", "product_name", "description", "quantity", "price", "tax_rate"];

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
        "bill_id" => "required|matches_bills[bills.id]",
        "product_name" => "required",
        "description" => "permit_empty|min_length[4]|max_length[250]",
        "quantity" => "required|numeric|greater_than[0]",
        "price" => "required|numeric",
        "tax_rate" => "required|in_list[23,8,5,0]"
    ];
    protected $validationMessages   = [
        "bill_id" => [
            "required" => "ID rachunku jest wymagane.",
            "matches_bills" => "Rachunek z tym ID nie istnieje w bazie danych."
        ],
        "product_name" => [
            "required" => "Nazwa produktu jest wymagana",
            "matches_products" => "Produkt o tej nazwie nie istnieje w bazie danych"
        ],
        "description" => [
            "min_length" => "Minimalna długość opisu to 4 znaki.",
            "max_length" => "Maksymalna długość opisu to 250 znaki."
        ],
        "quantity" => [
            "required" => "Ilość jest wymagana",
            "numeric" => "Ilość musi być liczbą całkowitą",
            "greater_than" => "Ilość musi być większa od 0"
        ],
        "price" => [
            "required" => "Cena jest wymagana",
            "numeric" => "Cena musi być liczbą"
        ],
        "tax_rate" => [
            "required" => "Procent podatku VAT jest wymagana.",
            "in_list" => "Procent podatku VAT może przyjąć wartość 23%, 8%, 5% lub 0%."
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

        if(!is_null($result)){
            $data = [];

            foreach($result as $entry){
                $name = $entry->product_name;
                $quantity = $entry->quantity;
                $price = $entry->price;
                $description = $entry->description;
                $tax_rate = $entry->tax_rate;

                $total = $quantity * $price;

                $data[] = [
                    "name" => $name,
                    "description" => $description,
                    "quantity" => $quantity,
                    "price" => $price,
                    "total" => $total,
                    "tax_rate" => $tax_rate
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

    public function addBillEntries(int $bill_id, array $bill_contents){
        foreach($bill_contents as $entry_data){
            $entry = new BillEntryEntity();
            $entry->fill([
                "bill_id" => $bill_id,
                "product_name" => $entry_data[0],
                "description" => $entry_data[1],
                "quantity" => $entry_data[2],
                "tax_rate" => $entry_data[3],
                "price" => $entry_data[4],
            ]);

            $val_result = $this->validate($entry);
            if($val_result){
                $this->save($entry);
            }
            else{
                return [
                    "status" => "valerr",
                    "errors" => $this->errors()
                ];
            }
        }

        return [
            "status" => "success"
        ];
    }
}
