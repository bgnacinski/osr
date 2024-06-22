<?php

namespace App\Models;

use App\Entities\ClientEntity;
use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ClientEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name", "nip", "email", "address"];

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
        "name" => "required|min_length[4]|max_length[255]|alpha_numeric_punct|is_unique[clients.name]",
        "nip" => "required|min_length[10]|max_length[10]|integer|valid_nip|is_unique[clients.nip]",
        "email" => "required|min_length[4]|max_length[255]|valid_email|is_unique[clients.email]",
        "address" => "required|min_length[10]|max_length[300]"
    ];
    protected $validationMessages   = [
        "name" => [
            "required" => "Nazwa firmy jest wymagana.",
            "min_length" => "Nazwa firmy musi zawierać od 4 do 250 znaków.",
            "max_length" => "Nazwa firmy musi zawierać od 4 do 250 znaków.",
            "alpha_numeric_punct" => "Nazwa firmy powinna zawierać jedynie znaki alfabetu, numery oraz znaki interpunkcyjne.",
            "is_unique" => "Podana nazwa jest powiązana z innym klientem."
        ],
        "nip" => [
            "required" => "NIP jest wymagany.",
            "min_length" => "NIP musi składać się z 10 znaków.",
            "max_length" => "NIP musi składać się z 10 znaków.",
            "integer" => "NIP musi być numerem.",
            "valid_nip" => "NIP jest niepoprawny.",
            "is_unique" => "Podany NIP jest powiązany z innym klientem."
        ],
        "email" => [
            "required" => "Adres e-mail jest wymagany.",
            "min_length" => "Adres e-mail musi mieć od 4 do 250 znaków.",
            "max_length" => "Adres e-mail musi mieć od 4 do 250 znaków.",
            "valid_email" => "Adres e-mail nie jest poprawny.",
            "is_unique" => "Podany adres e-mail jest powiązany z innym klientem."
        ],
        "address" => [
            "required" => "Adres jest wymagany.",
            "min_length" => "Adres powinien zawierać od 10 do 300 znaków.",
            "max_length" => "Adres powinien zawierać do 10 do 300 znaków."
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

    public function addClient(string $name, int $nip, string $email, string $address){
        $client_data = [
            "name" => $name,
            "nip" => (string)$nip,
            "email" => $email,
            "address" => $address
        ];

        if($this->validate($client_data)){
            $this->save($client_data);

            return [
                "status" => "success",
                "data" => $client_data
            ];
        }
        else{
            return [
                "status" => "valerr",
                "errors" => $this->errors()
            ];
        }
    }
}
