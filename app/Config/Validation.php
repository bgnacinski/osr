<?php

namespace Config;

use App\Models\BillModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
        NipValidator::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}


class CustomRules
{
    public function is_unique_users_soft_deleted(string $str, string $field, array $data, string &$error = null): bool
    {
        [$table, $field] = explode('.', $field);
        $model = new UserModel();

        // Sprawdź, czy istnieje rekord z podaną wartością (w tym miękko usunięte)
        $result = $model->withDeleted()
            ->where($field, $str)
            ->first();

        if ($result) {
            $error = 'The {field} field must contain a unique value.';
            return false;
        }

        return true;
    }

    public static function matches_users(string $str, string $field, array $data, string &$error = null): bool
    {
        $model = new UserModel();
        $login = $data["created_by"];

        $result = $model->where("login", $login)->findAll();

        if(count($result) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function matches_products(string $str, string $field, array $data, string &$error = null): bool
    {
        $model = new ProductModel();
        $product_name = $data["product_name"];

        $result = $model->where("name", $product_name)->findAll();

        if(count($result) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function matches_bills($str, string $field, array $data, string &$error = null): bool
    {
        $model = new BillModel();
        $bill_id = $data["bill_id"];

        $result = $model->where("id", $bill_id)->findAll();

        if(count($result) > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
