<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = UserEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["name", "login", "password", "role"];

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
        "name" => "required|min_length[4]|max_length[50]",
        "login" => "required|min_length[4]|max_length[50]|is_unique[users.login]",
        "password" => "required|min_length[8]",
        "role" => "required|in_list[superuser,manager,regular,viewer]"
    ];
    protected $validationMessages   = [
        "name" => [
            "required" => "Imię i nazwisko użytkownika jest wymagane.",
            "min_length" => "Minimalna długość pola z imionem i nazwiskiem to 4 znaki.",
            "max_length" => "Maksymalna długość pola z imionem i nazwiskiem to 50 znaków.",
        ],
        "login" => [
            "required" => "Login użytkownika jest wymagany.",
            "min_length" => "Minimalna długość loginu to 4 znaki.",
            "max_length" => "Maksymalna długość loginu to 50 znaków.",
            "is_unique" => "Ten login jest już używany."
        ],
        "password" => [
            "required" => "Hasło jest wymagane.",
            "min_length" => "Minimalna długość hasła to 8 znaków."
        ],
        "role" => [
            "required" => "Rola użytkownika jest wymagana.",
            "in_list" => "Rola może przyjmować wartości Administrator, Menadżer, Normalny lub Przeglądanie."
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["hashPassword"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function hashPassword($data){
        $data["data"]["password"] = password_hash($data["data"]["password"], PASSWORD_DEFAULT);

        return $data;
    }

    public function login($login, $password){
        $user = $this->where("login", $login)->first();

        if(!is_null($user)){
            if(password_verify($password, $user->password)){
                $user->password = null;

                return [
                    "success" => true,
                    "data" => $user
                ];
            }
            else{
                return [
                    "success" => false,
                    "type" => "accdenied"
                ];
            }
        }
        else{
            return [
                "success" => false,
                "type" => "notfound"
            ];
        }
    }
}
