<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Rachunek - <?= $bill_data->identificator; ?><?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Przeglądanie rachunku<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/view.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" media="print" href="/css/panel/bill-print.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/" class="button">Strona główna</a>
    <a href="/account/" class="button">Mój profil</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('message')) {
    $message = session("message");
    $success = (bool)session("success");

    if ($success) {
        echo <<<ENDL
            <div class="alert alert-success">
                $message
            </div>
        ENDL;
    } else {
        echo <<<ENDL
            <div class="alert alert-danger">
                $message
            </div>
        ENDL;
    }
}
?>
    <div id="bill">
        <div id="bill-info" class="heading">
            <p>
                <b>Numer rachunku:</b> <?= $bill_data->identificator; ?>
            </p>
            <p>
                <b>Data
                    wystawienia:</b> <?php $dateTime = datetime::createfromformat('Y-m-d H:i:s', $bill_data->created_at);
                echo $dateTime->format("Y-m-d"); ?>
            </p>
            <p class="hide-print">
                <b>Dodane przez:</b> <?= $bill_data->worker_name; ?>
            </p>
        </div>
        <div id="company-logo">
            <img src="<?= env("company.logo"); ?>" loading="lazy">
        </div>
        <div id="bill-sides">
            <div id="biller">
                <h5>Sprzedawca</h5>
                <p><?= env("company.bill_name"); ?></p>
                <p>
                    <b>Adres:</b><br>
                    <?= str_replace("|", "<br>", env("company.address")); ?>
                </p>
                <p>
                    <b>NIP:</b><br>
                    <?= env("company.nip"); ?>
                </p>
                <p><?= str_replace("|", " ", env("company.bank_account")); ?></p>
            </div>
            <div id="consumer">
                <h5>Nabywca</h5>
                <p><?= $bill_data->client_name; ?></p>
                <p>
                    <b>Adres:</b><br>
                    <?= str_replace("|", "<br>", $bill_data->client_address); ?>
                </p>
                <p>
                    <b>NIP:</b><br>
                    <?= $bill_data->client; ?>
                </p>
            </div>
        </div>
        <div id="bill-contents">
            <table id="bills-table">
                <thead>
                <th>Nazwa</th>
                <th class="hide-print">Opis</th>
                <th>Cena</th>
                <th>Ilość</th>
                <?php
                if ($bill_data->bill_type == "invoice") {
                    echo <<<ENDL
                        <th>Wartość netto</th>
                        <th>Stawka VAT</th>
                        <th>Wartość VAT</th>
                        <th>Wartość brutto</th>
                    ENDL;
                } else {
                    echo "<th>Wartość</th>";
                }
                ?>
                </thead>
                <tbody>
                <?php
                $bill_total_netto = 0;

                $tax_bracket_sum = [
                    "netto_value" => [
                        "0" => 0,
                        "5" => 0,
                        "8" => 0,
                        "23" => 0
                    ],
                    "tax_value" => [
                        "0" => 0,
                        "5" => 0,
                        "8" => 0,
                        "23" => 0
                    ],
                    "brutto_value" => [
                        "0" => 0,
                        "5" => 0,
                        "8" => 0,
                        "23" => 0
                    ]
                ];

                foreach ($bill_contents as $row) {
                    $name = $row["name"];
                    $description = $row["description"];
                    $price = $row["price"];
                    $quantity = $row["quantity"];
                    $total = $row["total"];
                    $tax_rate = $row["tax_rate"];

                    $bill_total_netto += $total;

                    echo <<<ENDL
                <tr class="data">
                    <td>$name</td>
                    <td class="hide-print">$description</td>
                    <td>$price PLN</td>
                    <td>$quantity</td>
                    <td>$total PLN</td>
                ENDL;

                    if ($bill_data->bill_type == "invoice") {
                        $tax_value = round($total * ($tax_rate / 100), 2);
                        $taxed_total = $total + $tax_value;

                        $tax_bracket_sum["netto_value"][$tax_rate] += $total;
                        $tax_bracket_sum["tax_value"][$tax_rate] += $tax_value;
                        $tax_bracket_sum["brutto_value"][$tax_rate] += $taxed_total;

                        echo <<<ENDL
                        <td>$tax_rate%</td>
                        <td>$tax_value PLN</td>
                        <td>$taxed_total PLN</td>
                        ENDL;
                    }

                    echo "</tr>";
                }
                ?>
                </tbody>

                <?php
                if($bill_data->bill_type != "invoice"){
                    echo <<<ENDL
                    <tr class="sum">
                        <td colspan="3">Suma</td>
                        <td class="hide-print"></td>
                        <td>$bill_total_netto PLN</td>
                    </tr>
                    ENDL;
                }
                ?>
            </table>

            <?php if($bill_data->bill_type == "invoice"){ ?>
            <table id="tax_sum">
                <thead>
                <th>Stawka VAT</th>
                <th>Suma netto</th>
                <th>Suma VAT</th>
                <th>Suma brutto</th>
                </thead>
                <tbody>
                <?php
                $bill_total_netto = 0;
                $bill_total_tax = 0;
                $bill_total_brutto = 0;

                foreach (["0", "5", "8", "23"] as $tax_rate) {
                    if ($tax_bracket_sum["netto_value"][$tax_rate] != 0) {
                        $netto = $tax_bracket_sum["netto_value"][$tax_rate];
                        $tax_value = $tax_bracket_sum["tax_value"][$tax_rate];
                        $brutto = $tax_bracket_sum["brutto_value"][$tax_rate];

                        $bill_total_netto += $netto;
                        $bill_total_tax += $tax_value;
                        $bill_total_brutto += $brutto;

                        echo <<<ENDL
                            <tr>
                                <th>$tax_rate%</th>
                                <td>$netto PLN</td>
                                <td>$tax_value PLN</td>
                                <td>$brutto PLN</td>
                            </tr>
                        ENDL;
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <tr class="sum">
                    <th>Razem</th>
                    <td><?= $bill_total_netto; ?> PLN</td>
                    <td><?= $bill_total_tax; ?> PLN</td>
                    <td><?= $bill_total_brutto; ?> PLN</td>
                </tr>
                </tfoot>
            </table>
            <?php }; ?>
        </div>
    </div>
<?= $this->endSection(); ?>