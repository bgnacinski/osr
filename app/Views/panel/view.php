<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/view.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/bills/add" class="button">Dodaj rachunek</a>
    <a href="/account/" class="button">Moje konto</a>
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
            <b>Wysokość podatku:</b> <?= $bill_data->tax_rate; ?>%
        </p>
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
                    <td>$amount zł</td>
                    <td>$quantity</td>
                    <td>$total zł</td>
                    <td>$total_tax zł</td>
                </tr>
                ENDL;
            }
            ?>
            <tr class="sum">
                <td>Suma</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $bill_total; ?> zł</td>
                <td><?= $bill_total_tax; ?> zł</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>