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
    <div id="bill-info" class="heading">
        <p>
            <b>Numer rachunku:</b> <?= $bill_data->identificator; ?>
        </p>
        <p>
            <b>Data wystawienia:</b> <?php $dateTime = datetime::createfromformat('Y-m-d H:i:s',$bill_data->created_at); echo $dateTime->format("Y-m-d"); ?>
        </p>
        <p class="hide-print">
            <b>Dodane przez:</b> <?= $bill_data->worker_name; ?>
        </p>
    </div>
    <div id="company-logo">
        <img src="<?= env("company.logo"); ?>">
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
                <th>Wartość netto</th>
            </thead>
            <tbody>
            <?php
            $bill_total = 0;
            $bill_total_tax = 0;

            $tax_rate = $bill_data->tax_rate;

            foreach($bill_contents as $row){
                $name = $row["name"];
                $description = $row["description"];
                $price = $row["price"];
                $quantity = $row["quantity"];
                $total = $row["total"];

                $bill_total += $total;

                echo <<<ENDL
                <tr class="data">
                    <td>$name</td>
                    <td class="hide-print">$description</td>
                    <td>$price PLN</td>
                    <td>$quantity</td>
                    <td>$total PLN</td>
                </tr>
                ENDL;
            }

            $bill_total_tax = $bill_total * (100 + $tax_rate);
            ?>
            </tbody>
            <tfoot>
                <tr class="sum">
                    <td>Suma</td>
                    <td class="hide-print"></td>
                    <td><?= $bill_total; ?> PLN</td>
                    <td><?= round($bill_total_tax - $bill_total, 2); ?> PLN</td>
                    <td><?= $bill_total_tax; ?> PLN</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>