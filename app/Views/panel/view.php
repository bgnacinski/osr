<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
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
    <h3>Rachunek: <?= $bill_data->identificator ?></h3>
    <div id="bill-contents">
        <table id="bills-table">
            <tbody>
            <tr>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Wartość</th>
            </tr>
            <?php
            $bill_total = 0;

            foreach($bill_contents as $bill){
                $name = $bill["name"];
                $description = $bill["description"];
                $amount = $bill["amount"];
                $quantity = $bill["quantity"];
                $total = $bill["total"];

                $bill_total += $total;

                echo <<<ENDL
                <tr class="data">
                    <td>$name</td>
                    <td>$description</td>
                    <td>$amount</td>
                    <td>$quantity</td>
                    <td>$total</td>
                </tr>
                ENDL;
            }
            ?>
            <tr class="sum">
                <td>Suma</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $bill_total; ?></td>
            </tr>
            </tbody>
        </table>
</div>
<?= $this->endSection(); ?>