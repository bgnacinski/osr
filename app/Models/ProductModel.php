<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ProductEntity;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ProductEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name", "description", "amount", "tax_rate"];

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
        "name" => "required|min_length[4]|max_length[100]",
        "description" => "permit_empty|min_length[4]|max_length[250]",
        "amount" => "required|decimal",
        "tax_rate" => "required|in_list[23,8,5,0]"
    ];
    protected $validationMessages   = [
        "name" => [
            "required" => "Nazwa jest wymagana.",
            "min_length" => "Minimalna długość nazwy to 4 znaki",
            "max_length" => "Maksymalna długość nazwy to 100 znaków."
        ],
        "description" => [
            "min_length" => "Minimalna długość opisu to 4 znaki.",
            "max_length" => "Maksymalna długość opisu to 250 znaki."
        ],
        "amount" => [
            "required" => "Cena jest wymagana",
            "decimal" => "Cena musi być liczbą(może zawierać przecinki)."
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
}
