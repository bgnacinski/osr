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
    protected $allowedFields    = ["identificator", "client", "status", "currency", "created_by"];

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
        "status" => "required|in_list[ok,pending,payment,returned]",
        "currency" => "required|in_list[AED, AFN, ALL, AMD, ANG, AOA, ARS, AUD, AWG, AZN, BAM, BBD, BDT, BGN, BHD, BIF, BMD, BND, BOB, BRL, BSD, BTN, BWP, BYN, BZD, CAD, CDF, CHF, CLP, CNY, COP, CRC, CUC, CUP, CVE, CZK, DJF, DKK, DOP, DZD, EGP, ERN, ETB, EUR, FJD, FKP, FOK, GBP, GEL, GGP, GHS, GIP, GMD, GNF, GTQ, GYD, HKD, HNL, HRK, HTG, HUF, IDR, ILS, IMP, INR, IQD, IRR, ISK, JEP, JMD, JOD, JPY, KES, KGS, KHR, KID, KMF, KRW, KWD, KYD, KZT, LAK, LBP, LKR, LRD, LSL, LYD, MAD, MDL, MGA, MKD, MMK, MNT, MOP, MRU, MUR, MVR, MWK, MXN, MYR, MZN, NAD, NGN, NIO, NOK, NPR, NZD, OMR, PAB, PEN, PGK, PHP, PKR, PLN, PYG, QAR, RON, RSD, RUB, RWF, SAR, SBD, SCR, SDG, SEK, SGD, SHP, SLL, SOS, SRD, SSP, STN, SYP, SZL, THB, TJS, TMT, TND, TOP, TRY, TTD, TVD, TWD, TZS, UAH, UGX, USD, UYU, UZS, VED, VES, VND, VUV, WST, XAF, XCD, XDR, XOF, XPF, YER, ZAR, ZMW, ZWL]",
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
        "currency" => [
            "required" => "Waluta jest wymagana.",
            "in_list" => "Podana waluta nie jest poprawna."
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

        $data["data"]["identificator"] = date("Y/m/d")."_".substr($hash, 0, 5);
        
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

    public function addBill(int $nip, string $status, string $currency, string $created_by, array $bill_contents){
        $bill_contents_model = new BillEntryModel();

        $bill_data = [
            "client" => (string)$nip,
            "status" => $status,
            "currency" => $currency,
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
