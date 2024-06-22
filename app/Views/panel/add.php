<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/add.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/form.css">
<script>
    var data = <?php echo json_encode($products, JSON_HEX_TAG); ?>;
</script>
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel" class="button">Strona główna</a>
    <a href="/panel/clients/" class="button">Klienci</a>
    <a href="/account/" class="button">Mój profil</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('success')){
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
        $errors = session("errors");

        echo '<div class="alert alert-danger"><ul>';
        foreach($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo '</ul></div>';
    }
}
?>

    <form method="post">
        <div class="form-floating mb-3">
            <input required list="nip" name="nip" type="numeric" class="form-control" id="floatingName" placeholder="NIP klienta">
            <label for="floatingName">NIP klienta</label>
            <datalist id="nip">
                <?php
                foreach($clients as $client){
                    echo <<<ENDL
                        <option value="$client->nip">$client->nip - $client->name</option>
                    ENDL;
                }
                ?>
            </datalist>
        </div>
        <div class="form-floating mb-3">
            <select required id="tax_rate" class="form-select" name="tax_rate" aria-label="Poziom VAT">
                <option value="23">23%</option>
                <option value="8">8%</option>
                <option value="5">5%</option>
                <option value="0">0%</option>
            </select>
            <label for="tax_rate">Poziom VAT</label>
        </div>
        <div class="form-floating mb-3">
            <select required id="status" class="form-select" name="status" aria-label="Status">
                <option value="ok">Zrealizowane</option>
                <option selected value="pending">W trakcie</option>
                <option value="payment">Do opłacenia</option>
            </select>
            <label for="tax_rate">Status</label>
        </div>

        <input type="text" required hidden id="bill_contents" name="bill_contents">

        <table class="mb-3">
            <tbody id="bill_contents_table">
                <tr>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Wartość netto</th>
                    <th>Wartość brutto</th>
                    <th></th>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Dodaj rachunek</button>
    </form>

    <div id="insert-form">
        <div class="form-floating mb-3">
            <select class="form-select" id="product_name" name="role" aria-label="Nazwa produktu">
                <?php
                foreach($products as $product){
                    echo <<<ENDL
                        <option value="$product->name">$product->name</option>
                    ENDL;
                }
                ?>
            </select>
            <label for="product_name">Nazwa produktu</label>
        </div>
        <div class="form-floating mb-3">
            <input type="numeric" class="form-control" id="quantity" placeholder="Ilość">
            <label for="quantity">Ilość</label>
        </div>

        <button class="btn btn-secondary" onclick="addEntry()">Dodaj do rachunku</button>
    </div>

<script src="/js/entry.js"></script>
<?= $this->endSection(); ?>