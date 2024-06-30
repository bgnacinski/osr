<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Klienci<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Klienci<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/panel/" class="button">Strona główna</a>
<a href="/panel/clients/add" class="button">Dodaj klienta</a>
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
        <input type="text" list="nip" name="nip" class="form-control" id="floatingInput" placeholder="NIP">
        <label for="floatingInput">NIP</label>
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
    <input type="submit" value="Szukaj">
</form>
<table id="clients-table">
    <tbody>
    <tr>
        <th>Nazwa</th>
        <th>NIP</th>
        <th>Adres</th>
        <th>Adres e-mail</th>
        <th>Data dodania</th>
        <th>Data zmiany danych</th>
        <th>Data usunięcia</th>
        <th>Operacje</th>
    </tr>
    <?php
    foreach($clients as $client){
        $address = str_replace("|", ", ", $client->address);
        $updated_at = $client->updated_at ?? "-";
        $deleted_at = $client->deleted_at ?? "-";

        echo <<<ENDL
                <tr class="data">
                    <td>$client->name</td>
                    <td>$client->nip</td>
                    <td>$client->email</td>
                    <td>$address</td>
                    <td>$client->created_at</td>
                    <td>$updated_at</td>
                    <td>$deleted_at</td>
                    <td>
                        <a class="table-button" href="/panel/clients/view/$client->id"><span class="material-symbols-outlined view-icon">visibility</span></a>
                    </td>
                </tr>
            ENDL;
    }
    ?>
    </tbody>
</table>
<nav aria-label="pagination">
    <ul class="mt-3 pagination justify-content-center">
        <li class="page-item">
            <a class="page-link <?= $page_data["previous"]; ?>" href="/panel/<?= $page_data["last_page"]; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item active"><a class="page-link" href="/panel/<?= $page_data["current"];?>"><?= $page_data["current"];?>/<?= $page_data["available"];?></a></li>
        <li class="page-item <?= $page_data["next"]; ?>">
            <a class="page-link" href="/panel/<?= $page_data["next_page"]; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?= $this->endSection(); ?>
