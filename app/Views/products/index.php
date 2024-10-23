<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Produkty<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Produkty<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/panel/" class="button">Strona główna</a>
<a href="/panel/products/add" class="button">Dodaj produkt</a>
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
<form id="search-bar" method="get">
    <div class="form-floating">
        <input type="text" list="products" name="product_name" class="form-control" id="floatingInput" placeholder="Nazwa produktu">
        <label for="floatingInput">Nazwa produktu</label>
        <datalist id="products">
            <?php
            foreach($products as $product){
                echo <<<ENDL
                        <option value="$product->friendly_id">$product->name - $product->amount</option>
                    ENDL;
            }
            ?>
        </datalist>
    </div>
    <input type="submit" value="Szukaj">
</form>
<table id="clients-table">
    <thead>
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Cena</th>
        <th>Stawka VAT</th>
        <th>Data dodania</th>
    </thead>
    <tbody>
    <?php
    foreach($products as $product){
        $updated_at = $product->updated_at ?? "-";

        echo <<<ENDL
                <tr class="data">
                    <td>$product->name</td>
                    <td>$product->description</td>
                    <td>$product->amount PLN</td>
                    <td>$product->tax_rate%</td>
                    <td>$product->created_at</td>    
            ENDL;

        if($user->role == "manager") {
            echo <<<ENDL
                    <td>
                        <a class="table-button" href="/panel/products/delete/$product->id" title="Usuń produkt"><span class="material-symbols-outlined delete-icon">delete</span></a>
                    </td>
            ENDL;
        }

        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<nav aria-label="pagination">
    <ul class="mt-3 pagination justify-content-center">
        <li class="page-item">
            <a class="page-link <?= $page_data["previous"]; ?>" href="/panel/products/<?= $page_data["last_page"]; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item active"><a class="page-link" href="/panel/products/<?= $page_data["current"];?>"><?= $page_data["current"];?>/<?= $page_data["available"];?></a></li>
        <li class="page-item <?= $page_data["next"]; ?>">
            <a class="page-link" href="/panel/products/<?= $page_data["next_page"]; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?= $this->endSection(); ?>
