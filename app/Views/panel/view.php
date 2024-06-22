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
    <a href="/panel/bills/add" class="button">Dodaj rachunek</a>
    <a href="/account/" class="button">Mój profil</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('message')){
    $message = session("message");
    $success = (bool)session("success");

    if($success){
        echo <<<ENDL
            <div class="alert alert-success">
                $message
            </div>
        ENDL;
    }
    else{
        echo <<<ENDL
            <div class="alert alert-danger">
                $message
            </div>
        ENDL;
    }
}
?>
<div id="bill">
    <div id="bill-info">
        <p>
            <b>Identyfikator:</b> <?= $bill_data->identificator; ?>
        </p>
        <p>
            <b>Data wystawienia:</b> <?= $bill_data->created_at; ?>
        </p>
        <p class="hide-print">
            <b>Dodane przez:</b> <?= $bill_data->created_by; ?>
        </p>
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
            <p><?= $client_data->name; ?></p>
            <p>
                <b>Adres:</b><br>
                <?= str_replace("|", "<br>", $client_data->address); ?>
            </p>
            <p>
                <b>NIP:</b><br>
                <?= $client_data->nip; ?>
            </p>
        </div>
    </div>
    <div id="bill-contents">
        <table id="bills-table">
            <tbody>
            <tr>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Wartość netto</th>
                <th>Wartość brutto</th>
            </tr>
            <?php
            $bill_total = 0;
            $bill_total_tax = 0;

            foreach($bill_contents as $bill){
                $multiplier = (100 + $bill_data->tax_rate)/100;

                $name = $bill["name"];
                $description = $bill["description"];
                $amount = $bill["amount"];
                $quantity = $bill["quantity"];
                $total = $bill["total"];
                $total_tax = round($bill["total"] * $multiplier, 2);

                $bill_total += $total;
                $bill_total_tax += $total_tax;

                echo <<<ENDL
                <tr class="data">
                    <td>$name</td>
                    <td>$description</td>
                    <td>$amount <span class="hide-print"><?= $bill_data->currency ;?></span></td>
                    <td>$quantity</td>
                    <td>$total <span class="hide-print"><?= $bill_data->currency ;?></span></td>
                    <td>$total_tax <span class="hide-print"><?= $bill_data->currency ;?></span></td>
                </tr>
                ENDL;
            }
            ?>
            <tr class="sum">
                <td>Suma</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <?= $bill_total; ?>
                    <span><?= $bill_data->currency ;?></span>
                </td>
                <td>
                    <?= $bill_total_tax; ?>
                    <span><?= $bill_data->currency ;?></span>
                </td>
            </tr>
            </tbody>
        </table>
        <div id="bill-metadata">
            <p>
                <b>VAT:</b> <?= $bill_data->tax_rate; ?>%
            </p>
            <p>
                <b>Waluta:</b> <?= $bill_data->currency; ?>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>