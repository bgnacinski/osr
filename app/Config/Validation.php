<?php

namespace Config;

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
    public function is_unique_soft_deleted(string $str, string $field, array $data, string &$error = null): bool
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
}
