<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie rachunku - zlecenie <?= $job->identificator; ?><?= $this->endSection(); ?>
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

    <form id="bill_form" method="post" action="/panel/bills/add/<?= $job->identificator; ?>">
        <div class="form-floating mb-3">
            <input readonly value="<?= $job->client; ?>" required list="nip" name="client" type="numeric" class="form-control" id="floatingName" placeholder="NIP klienta">
            <label for="floatingName">NIP klienta</label>
        </div>
        <div class="form-floating mb-3">
            <select id="tax_rate" name="tax_rate" class="form-control">
                <option value="23">23%</option>
                <option selected value="8">8%</option>
                <option value="7">7%</option>
                <option value="5">5%</option>
                <option value="4">4%</option>
                <option value="none">Brak</option>
            </select>
            <label for="tax_rate">Wysokość podatku VAT</label>
        </div>

        <input type="text" required hidden id="bill_contents" name="bill_contents">
    </form>

        <table class="mb-3">
            <thead>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Wartość netto</th>
            </thead>
            <tbody id="bill_contents_table"></tbody>
            <tfoot>
                <td>
                    <input type="text" class="form-control" list="name_list" name="name" id="name" placeholder="Nazwa">
                    <datalist id="name_list">
                        <?php
                        foreach($products as $product){
                            echo <<<ENDL
                            <option value="$product->name">$product->description</option>
                        ENDL;
                        }
                        ?>
                    </datalist>
                </td>
                <td>
                    <input type="text" class="form-control" name="description" id="description" placeholder="Opis">
                </td>
                <td>
                    <input type="numeric" class="form-control" name="price" id="price" placeholder="Cena">
                </td>
                <td>
                    <input type="numeric" class="form-control" min="1" name="quantity" id="quantity" placeholder="Ilość">
                </td>
                <td></td>
                <td>
                    <button class="btn btn-success" onclick="addEntry()">
                        <h5>+</h5>
                    </button>
                </td>
            </tfoot>
        </table>
        <button type="submit" class="btn btn-primary" form="bill_form">Dodaj rachunek</button>
<script src="/js/entry.js"></script>
<?= $this->endSection(); ?>